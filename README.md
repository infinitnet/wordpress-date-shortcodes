# WordPress Date Shortcodes
WordPress plugin that adds shortcodes for current, published, and last modified year and month.

## Purpose
The main purpose of this plugin is to dynamically add dates to post titles. The shortcodes also work in meta descriptions (Rank Math, Yoast, SEOPress) and post content.

You can use the `adjust` parameter for `[currentday]` to display the date for tomorrow, yesterday, the day after tomorrow, etc. This can be useful to make discounts always expire "tomorrow", for example: "Hurry up! This discount expires on `[currentmonth] [currentday adjust="+1"]`!"

All other shortcodes also support the `adjust` parameter, e.g. `[currentmonth adjust="+1"]` will show the month after the current one, `[currentyear adjust="+1"]` will show the next year, etc.

## Available Shortcodes
- **[currentday adjust="+1"]** - tomorrow (both `+` and `-` are supported)
- **[currentday]** - current day
- **[currentmonth]** - current month
- **[currentyear]** - current year
- **[publishedday]** - day the post/page was published
- **[publishedmonth]** - month the post/page was published
- **[publishedyear]** - year the post/page was published
- **[modifiedday]** - day the post/page was last modified
- **[modifiedmonth]** - month the post/page was last modified
- **[modifiedyear]** - year the post/page was last modified

**Note:** The `adjust` parameter is supported by all shortcodes and can use both `+` and `-` depending on whether you want to display future or past dates.

## Compatibility
The WordPress Date Shortcodes plugin is compatible with:
- Rank Math
- Yoast SEO
- SEOPress
- Contextual Related Posts (CRP)
