# Blog Posts

Each post is a **completely self-contained PHP file** with its own metadata and HTML content.

## Structure

Each post file has:
1. **Metadata array** at the top (for listing pages)
2. **Page setup** (header, hero)
3. **HTML content** written directly in the file
4. **Footer** at the bottom

## Example Post

See `inscriptions-2025.php` for a complete example.

## Creating a New Post

1. Create a new PHP file in this directory (e.g., `my-new-post.php`)
2. Copy the structure from `inscriptions-2025.php`
3. Update the `$post_metadata` array
4. Write your HTML content
5. Done! It will automatically appear on the news page

## Post Template

```php
<?php
// Post metadata (used for listings)
$post_metadata = [
    'title' => 'Your Post Title',
    'date' => '2025-12-02',
    'image' => 'assets/your-image.jpg',
    'excerpt' => 'Short description shown on listing pages'
];

// Only render if not being included for metadata
if (!isset($metadata_only)) {
    $post_title = $post_metadata['title'];
    $post_date = $post_metadata['date'];
    $post_image = $post_metadata['image'];

    $config = require __DIR__ . '/../config.php';
    $page_title = $post_title . " - " . $config['site_name'];
    $hero_title = $post_title;
    $hero_subtitle = date('d M Y', strtotime($post_date));
    $hero_bg = $post_image;

    include __DIR__ . '/../includes/header.php';
    include __DIR__ . '/../includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[800px] mx-auto px-4 prose lg:prose-xl">

        <!-- Your HTML content here -->
        <p>Your content...</p>

        <div class="mt-12 pt-8 border-t-2 border-border">
            <a href="../news.php">← Retour aux actualités</a>
        </div>
    </div>
</section>

<?php
    include __DIR__ . '/../includes/footer.php';
}
?>
```

## How It Works

- The listing pages (news.php, index.php) scan this directory
- They set `$metadata_only = true` before including each file
- This extracts just the metadata without rendering the full page
- When accessed directly, the post renders normally with header/footer

## Benefits

✅ **One file per post** - everything in one place
✅ **No separate metadata files** - metadata is at the top of the post
✅ **Simple** - just copy/paste the template and edit
✅ **Automatic** - new posts appear automatically on listing pages
