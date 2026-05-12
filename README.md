# webfurious.github.io

Source for [webfurious.github.io](https://webfurious.github.io) — the marketing site for Webfurious Designs and the StudioFlow Android app.

## Forms

This site uses [Formspree](https://formspree.io) for form handling. Forms are configured at the following endpoints:

| Form | Endpoint | Formspree ID |
|------|----------|--------------|
| Beta Feedback / Bug Report | `https://formspree.io/f/xgoddrzk` | `xgoddrzk` |
| Contact | `https://formspree.io/f/mlgzzawr` | `mlgzzawr` |
| Beta Signup | `https://formspree.io/f/xaqpqqgq` | `xaqpqqgq` |

### Updating Forms

If you need to change a form endpoint, update the `action` attribute in the corresponding HTML file:

- `beta-feedback-form.html` → beta feedback form
- `contact.html` → contact form
- `beta-signup-form.html` → beta signup form

All form submissions are managed at [formspree.io](https://formspree.io).

## Site Structure

- `index.html` — homepage
- `about.html` — about page
- `services.html` — services page
- `portfolio.html` — portfolio page
- `contact.html` — contact form
- `download.html` — StudioFlow download / info page
- `beta-signup-form.html` — beta signup form page
- `beta-feedback-form.html` — beta feedback / bug report form page
- `privacy.html` — privacy policy
- `StudioFlow.html` — StudioFlow project page

## Tech Stack

- Plain HTML/CSS/JS (no framework)
- [Font Awesome](https://fontawesome.com) for icons
- Google Fonts (Inter, JetBrains Mono)
- [Formspree](https://formspree.io) for forms
- GitHub Pages for hosting

## Hosting

The site is hosted on **GitHub Pages**. Any push to `main` automatically deploys.

## Local Development

```bash
# Clone the repo
git clone https://github.com/webfurious/webfurious.github.io.git
cd webfurious.github.io

# Serve locally (any static server works)
python3 -m http.server 8000
```

Then open `http://localhost:8000`
