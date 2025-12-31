# Meyrin CTT - Kirby 5 Theme

A custom Kirby CMS theme for Meyrin CTT (Club de Tennis de Table Meyrin), converted from a static PHP website.

## Features

- 🎨 **Customizable Theme** - All colors and fonts configurable via the Panel
- 📱 **Responsive Design** - Mobile-first approach with Tailwind CSS
- 📰 **News Management** - Blog-style news/articles system
- 📷 **Photo Gallery** - Album management with lightbox
- 📧 **Contact Form** - Built-in contact form with email notifications
- ⚙️ **Panel Settings** - All site configuration editable in the Panel
- 🎄 **Holiday Decorations** - Optional winter holiday decorations

## Installation

### Requirements

- PHP 8.2+
- Kirby 5.x
- Web server (Apache, Nginx, etc.)

### Setup

1. **Copy the Kirby core:**
   ```bash
   # Copy the kirby folder from the starterkit
   cp -r ../starterkit-main/kirby ./kirby
   ```

2. **Set up your web server** to point to this directory

3. **Access the Panel:**
   - Go to `yoursite.com/panel`
   - Create an admin account on first visit

4. **Configure your site:**
   - Go to Site Settings in the Panel
   - Configure theme colors, contact settings, etc.

## Directory Structure

```
kirby-meyrinctt/
├── assets/
│   ├── css/
│   │   └── index.css       # Custom styles
│   └── js/
│       └── index.js        # Custom JavaScript
├── content/
│   ├── site.txt            # Site settings
│   ├── accueil/            # Home page
│   ├── club/               # Club page
│   ├── horaires/           # Schedule page
│   ├── inscription/        # Registration page
│   ├── galerie/            # Gallery page
│   ├── actualites/         # News listing
│   └── contact/            # Contact page
├── site/
│   ├── blueprints/
│   │   ├── site.yml        # Site settings blueprint
│   │   └── pages/          # Page blueprints
│   ├── config/
│   │   └── config.php      # Kirby configuration
│   ├── snippets/           # Reusable components
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── nav.php
│   │   ├── hero.php
│   │   └── ...
│   └── templates/          # Page templates
│       ├── accueil.php
│       ├── club.php
│       ├── horaires.php
│       └── ...
├── .htaccess               # Apache rewrite rules
├── index.php               # Main entry point
└── README.md               # This file
```

## Configuration

### Site Settings (Panel)

All site configuration is managed through the Panel under "Site Settings":

| Tab | Settings |
|-----|----------|
| **Thème** | Colors, fonts |
| **Paramètres** | General settings, announcement banner |
| **Contact** | Email configuration, club address |
| **Pied de page** | Footer content, social links |

### Theme Colors

Configure in Panel → Site Settings → Thème:

- `color_primary` - Main brand color (#0056b3)
- `color_primary_light` - Light variant (#e3f2fd)
- `color_bg` - Background color (#f8f9fa)
- `color_surface` - Card/surface color (#ffffff)
- `color_text` - Text color (#1a1a1a)
- `color_border` - Border color (#004494)
- `color_accent` - Accent color (#d32f2f)

### Contact Settings

Configure in Panel → Site Settings → Contact:

- `email_to` - Recipient email for contact form
- `email_from` - Sender email address
- `email_subject` - Default email subject
- `enable_notifications` - Toggle email notifications

## Page Types

| Template | Description |
|----------|-------------|
| `accueil` | Home page with hero, news, and club sections |
| `club` | Club info, history, committee, notable players |
| `horaires` | Training schedule with timetable |
| `inscription` | Registration info and fee tables |
| `galerie` | Photo gallery listing |
| `album` | Individual photo album |
| `actualites` | News listing with pagination |
| `article` | Single news article |
| `contact` | Contact form and info |
| `default` | Generic page with text content |

## Adding Content

### News Articles

1. Go to Panel → Actualités → Add
2. Fill in title, date, excerpt
3. Add content using the block editor
4. Upload a cover image

### Photo Albums

1. Go to Panel → Galerie → Add
2. Enter album title and description
3. Upload photos to the album

### Pages

Each page can be edited in the Panel with appropriate fields for that page type.

## Customization

### Adding New Templates

1. Create blueprint in `site/blueprints/pages/`
2. Create template in `site/templates/`
3. Create content folder in `content/`

### Modifying Snippets

Edit files in `site/snippets/` to change:
- Header/footer layout
- Navigation structure
- Hero sections
- Card components

### Custom CSS

Add styles to `assets/css/index.css` or use Tailwind classes directly in templates.

## Migration from Original Site

The original static PHP site has been converted to Kirby:

| Original | Kirby |
|----------|-------|
| `config.php` | Panel settings (site.yml blueprint) |
| `includes/*.php` | `site/snippets/` |
| `*.php` pages | `site/templates/` + `content/` |
| `posts/*.php` | `content/actualites/*/article.txt` |
| `assets/albums/` | `content/galerie/*/` |

## Support

For issues or questions about this theme, contact the Meyrin CTT webmaster.

## License

This theme is custom-made for Meyrin CTT. Kirby CMS requires a license for production use - see [getkirby.com](https://getkirby.com).
