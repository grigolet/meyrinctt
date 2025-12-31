<?php
/**
 * File Block Snippet
 * Renders an attached file with icon and download link
 */

$file = $block->file()->toFile();
$caption = $block->caption()->or('Télécharger le fichier');
$showAsLink = $block->link()->toBool();

if (!$file) return;

$extension = strtoupper($file->extension());
$size = $file->niceSize();

// Icon mapping based on file type
$iconMap = [
    'PDF' => '📄',
    'DOC' => '📝',
    'DOCX' => '📝',
    'XLS' => '📊',
    'XLSX' => '📊',
    'ZIP' => '🗜️',
    'RAR' => '🗜️',
    'TXT' => '📃',
];

$icon = $iconMap[$extension] ?? '📎';
?>

<?php if ($showAsLink): ?>
<div class="file-block">
    <a href="<?= $file->url() ?>" class="file-link" download>
        <span class="file-icon"><?= $icon ?></span>
        <div class="file-info">
            <span class="file-caption"><?= $caption ?></span>
            <span class="file-meta"><?= $extension ?> • <?= $size ?></span>
        </div>
        <span class="download-icon">⬇️</span>
    </a>
</div>

<style>
.file-block {
    margin: 2rem 0;
}

.file-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

.file-link:hover {
    background: #e9ecef;
    border-color: #dee2e6;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.file-icon {
    font-size: 2rem;
    line-height: 1;
}

.file-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.file-caption {
    font-weight: 600;
    font-size: 1rem;
}

.file-meta {
    font-size: 0.875rem;
    color: #6c757d;
}

.download-icon {
    font-size: 1.5rem;
    opacity: 0.6;
    transition: opacity 0.2s ease;
}

.file-link:hover .download-icon {
    opacity: 1;
}
</style>

<?php else: ?>
<div class="file-block file-embed">
    <div class="file-header">
        <span class="file-icon"><?= $icon ?></span>
        <div class="file-info">
            <span class="file-caption"><?= $caption ?></span>
            <span class="file-meta"><?= $extension ?> • <?= $size ?></span>
        </div>
    </div>
</div>
<?php endif; ?>
