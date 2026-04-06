# Instagram Feed Fetcher Plugin

A WordPress plugin to fetch and display Instagram feeds using the Instagram Graph API.

## Features

- Fetch Instagram posts from your business account
- Display posts in a responsive grid layout
- Show post captions and engagement stats
- Easy shortcode integration
- Admin settings page for API credentials
- Caching for better performance

## Installation

1. Download the plugin as ZIP from the repository
2. Extract the folder to `/wp-content/plugins/`
3. Go to WordPress Admin → Plugins
4. Find "Instagram Feed Fetcher" and click **Activate**

## Setup

1. Go to WordPress Admin → **Instagram Feed**
2. Enter your Instagram Graph API credentials:
   - **Access Token**: Your Instagram Graph API access token
   - **Business Account ID**: Your Instagram Business Account ID
3. Click **Save Changes**
4. Test the connection

## Usage

Add the shortcode to any post or page:

```
[instagram_feed limit="12" columns="3" show_captions="true" show_stats="true"]
```

### Shortcode Parameters

- `limit` - Number of posts to display (default: 12)
- `columns` - Number of columns in grid (default: 3)
- `show_captions` - Display post captions (default: false)
- `show_stats` - Display likes and comments count (default: false)

## Requirements

- WordPress 5.0+
- PHP 7.2+
- Instagram Business Account
- Instagram Graph API Access Token

## File Structure

```
Instafeed-Yashpal/
├── instagram-feed.php          # Main plugin file
├── includes/
│   ├── class-instagram-api.php # Instagram API handler
│   └── class-shortcode.php     # Shortcode rendering
├── admin/
│   └── class-settings.php      # Admin settings page
└── assets/
    └── style.css               # Plugin styles
```

## License

GPL v2 or later

## Author

Yashpal