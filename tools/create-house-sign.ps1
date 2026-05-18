Add-Type -AssemblyName PresentationCore
Add-Type -AssemblyName WindowsBase

$ErrorActionPreference = "Stop"
$culture = [System.Globalization.CultureInfo]::InvariantCulture
$workspace = (Resolve-Path ".").Path
$outDir = Join-Path $workspace "assets\laser-cut"
New-Item -ItemType Directory -Force -Path $outDir | Out-Null

function New-TextGeometry {
    param(
        [string] $Text,
        [double] $X,
        [double] $Y,
        [double] $FontSize
    )

    $typeface = [System.Windows.Media.Typeface]::new(
        [System.Windows.Media.FontFamily]::new("Segoe Script"),
        [System.Windows.FontStyles]::Normal,
        [System.Windows.FontWeights]::Regular,
        [System.Windows.FontStretches]::Normal
    )

    $formatted = [System.Windows.Media.FormattedText]::new(
        $Text,
        $culture,
        [System.Windows.FlowDirection]::LeftToRight,
        $typeface,
        $FontSize,
        [System.Windows.Media.Brushes]::Black,
        1.0
    )

    $geometry = $formatted.BuildGeometry([System.Windows.Point]::new($X, $Y))
    return $geometry.GetOutlinedPathGeometry()
}

function New-WidenedCurve {
    param(
        [string] $PathData,
        [double] $StrokeWidth
    )

    $geometry = [System.Windows.Media.Geometry]::Parse($PathData)
    $pen = [System.Windows.Media.Pen]::new([System.Windows.Media.Brushes]::Black, $StrokeWidth)
    $pen.StartLineCap = [System.Windows.Media.PenLineCap]::Round
    $pen.EndLineCap = [System.Windows.Media.PenLineCap]::Round
    $pen.LineJoin = [System.Windows.Media.PenLineJoin]::Round
    return $geometry.GetWidenedPathGeometry($pen)
}

function Union-Geometries {
    param([System.Windows.Media.Geometry[]] $Geometries)

    $result = $Geometries[0]
    for ($i = 1; $i -lt $Geometries.Count; $i++) {
        $result = [System.Windows.Media.Geometry]::Combine(
            $result,
            $Geometries[$i],
            [System.Windows.Media.GeometryCombineMode]::Union,
            $null
        )
    }
    return $result.GetOutlinedPathGeometry()
}

$maisonText = New-TextGeometry -Text "Maison" -X 0 -Y 0 -FontSize 148
$maison = $maisonText

$colombelle = New-TextGeometry -Text "Colombelle" -X 65 -Y 150 -FontSize 188

$allBounds = [System.Windows.Rect]::Union($maison.Bounds, $colombelle.Bounds)
$margin = 18
$translate = [System.Windows.Media.TranslateTransform]::new($margin - $allBounds.X, $margin - $allBounds.Y)
$maison.Transform = $translate
$colombelle.Transform = $translate

# The dot over the "i" would otherwise cut as a loose third island, and the
# initial capital needs a small join to keep Maison to a single metal piece.
$maisonInitialBridge = New-WidenedCurve -PathData "M 137,129 C 146,121 157,110 170,99" -StrokeWidth 8
$maisonIDotBridge = New-WidenedCurve -PathData "M 280,38 C 276,49 273,62 271,76" -StrokeWidth 7
$maison = Union-Geometries -Geometries @($maison.GetOutlinedPathGeometry(), $maisonInitialBridge, $maisonIDotBridge)

$maisonPath = $maison.GetOutlinedPathGeometry().ToString($culture) -replace "F[01]\s*", ""
$colombellePath = $colombelle.GetOutlinedPathGeometry().ToString($culture) -replace "F[01]\s*", ""

$bounds = [System.Windows.Rect]::Union($maison.Bounds, $colombelle.Bounds)
$width = [Math]::Ceiling($bounds.X + $bounds.Width + $margin)
$height = [Math]::Ceiling($bounds.Y + $bounds.Height + $margin)

$svg = @"
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="${width}mm" height="${height}mm" viewBox="0 0 $width $height">
  <title>Maison Colombelle laser-cut sign</title>
  <desc>Two filled vector pieces: Maison and Colombelle. The dot on the i in Maison is bridged to keep the sign to two cut metal pieces.</desc>
  <g id="cut-pieces" fill="#000000" stroke="none" fill-rule="evenodd">
    <path id="piece-1-maison" d="$maisonPath"/>
    <path id="piece-2-colombelle" d="$colombellePath"/>
  </g>
</svg>
"@

$svgPath = Join-Path $outDir "maison-colombelle-laser-cut.svg"
Set-Content -Path $svgPath -Value $svg -Encoding UTF8

$scale = 2
$preview = [System.Windows.Media.DrawingVisual]::new()
$drawing = $preview.RenderOpen()
$drawing.DrawRectangle([System.Windows.Media.Brushes]::White, $null, [System.Windows.Rect]::new(0, 0, $width * $scale, $height * $scale))
$drawing.PushTransform([System.Windows.Media.ScaleTransform]::new($scale, $scale))
$drawing.DrawGeometry([System.Windows.Media.Brushes]::Black, $null, $maison)
$drawing.DrawGeometry([System.Windows.Media.Brushes]::Black, $null, $colombelle)
$drawing.Pop()
$drawing.Close()

$bitmap = [System.Windows.Media.Imaging.RenderTargetBitmap]::new($width * $scale, $height * $scale, 96, 96, [System.Windows.Media.PixelFormats]::Pbgra32)
$bitmap.Render($preview)
$encoder = [System.Windows.Media.Imaging.PngBitmapEncoder]::new()
$encoder.Frames.Add([System.Windows.Media.Imaging.BitmapFrame]::Create($bitmap))
$pngPath = Join-Path $outDir "maison-colombelle-preview.png"
$stream = [System.IO.File]::Open($pngPath, [System.IO.FileMode]::Create)
try {
    $encoder.Save($stream)
}
finally {
    $stream.Dispose()
}

Write-Output $svgPath
Write-Output $pngPath
