# Psychotherapy Setup Wizard - User Guide

## 📋 Table of Contents

1. [Overview](#overview)
2. [Prerequisites](#prerequisites)
3. [Step-by-Step Guide](#step-by-step-guide)
4. [Important Notes](#important-notes)
5. [Troubleshooting](#troubleshooting)
6. [FAQ](#faq)

---

## 🎯 Overview

The **Psychotherapy Setup Wizard** guides you through the complete setup of your psychotherapy website. The wizard consists of **16 steps** and automates the installation and configuration of all required components.

### What the Wizard Sets Up:

- ✅ Hello Theme & Elementor
- ✅ Elementor Pro with license activation
- ✅ Template Kit import
- ✅ ACF fields for Team Members
- ✅ Team Settings & Elementor configuration
- ✅ Demo data (optional)
- ✅ WordPress basic settings
- ✅ Colors, fonts and styles
- ✅ Template assignments

### Estimated Duration: 15-30 minutes

---

## ⚙️ Prerequisites

Before starting the setup, make sure you have the following ready:

### 📁 Required Files

1. **Elementor Pro ZIP** - Current Elementor Pro plugin file
2. **Elementor Pro License Key** - Your valid license key
3. **Template Kit ZIP** - Your Elementor Website Kit as ZIP file
4. **ACF JSON File** - Team Member ACF fields (e.g., `acf-export.json`)
5. **Demo Data XML** (optional) - Sample Team Members (e.g., `team-demo.xml`)
6. **Styling Plugin ZIP** (optional) - If available

### 💻 Technical Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher
- At least 256MB PHP Memory Limit
- Active internet connection

---

## 📖 Step-by-Step Guide

### Step 1: Welcome 👋

The welcome screen gives you an overview of the setup process.

**Actions:**
- Read the information
- Click **"Let's Go →"**

**Note:** If you interrupt the wizard, you can continue later via the "Continue" card.

---

### Step 2: Install Hello Theme 🎨

Hello Theme is a minimalistic theme optimized for Elementor.

**Actions:**
1. Click **"Install"** next to "Hello Theme"
2. Wait for confirmation (status turns green: "Installed")
3. Click **"Next →"**

**Status Display:**
- 🔘 Ready - Theme not yet installed
- ⏳ Installing... - Installation in progress
- ✅ Installed - Theme successfully installed

**Progress Bubble:** Turns green automatically after successful installation

---

### Step 3: Install Elementor ⚙️

Elementor is the page builder for your website.

**Actions:**
1. Click **"Install"** next to "Elementor"
2. Wait for confirmation
3. Click **"Next →"**

**Note:** Installation may take 30-60 seconds.

---

### Step 4: Upload & Activate Elementor Pro 🚀

Elementor Pro extends Elementor with professional features.

**Actions:**
1. **Upload Elementor Pro:**
   - Click the upload area or drag & drop the ZIP file
   - Wait for upload confirmation
   - License activation section appears automatically

2. **Activate License:**
   - Click **"Activate Elementor Pro License (new tab)"**
   - Enter your license key and activate it
   - Return to wizard tab
   - Click **"🔄 Check License Status"**
   - When license is active (green box), click **"Next →"**

**Important:**
- ⚠️ License MUST be active before proceeding
- Progress bubble only turns green when license is activated

**Troubleshooting:**
- If "License not yet active" is shown, reactivate license in Elementor tab
- Then check status again

---

### Step 5: Import Template Kit 📦

Your Elementor Website Kit contains all templates, pages and settings.

**Actions:**
1. Click **"🚀 Open Elementor Kit Import (new tab)"**
2. In Elementor tab:
   - Click **"Upload"**
   - Select your Template Kit ZIP file
   - Choose what to import:
     - ✅ Templates
     - ✅ Content (Pages)
     - ✅ Site Settings
   - Click **"Import"**
   - Wait until import is complete (1-3 minutes)
3. Return to wizard tab
4. Click **"🔄 Check Import Status"**

**Status Display:**
- ✅ Green box - Templates found, import successful
- ⚠️ Yellow box - No templates found yet, please import first

**Progress Bubble:** Turns green automatically when templates are detected

**Important:**
- Import may take 1-3 minutes, please be patient
- Don't leave Elementor tab until import is complete

---

### Step 6: Import ACF Fields 📝

ACF (Advanced Custom Fields) fields define the Team Member structure.

**Actions:**
1. Click upload area
2. Select your ACF JSON file (e.g., `acf-export.json`)
3. Wait for upload confirmation
4. Green success notification appears top-right
5. Click **"Next →"**

**What Gets Imported:**
- Team Member Custom Post Type
- 40+ ACF fields for Team Member profiles
- Field Groups with location rules

**Progress Bubble:** Turns green automatically after successful upload

---

### Step 7: Configure Team Settings 👥

Enables Team Members in Elementor and disables default schemas.

**Actions:**
1. Click **"⚙️ Open Elementor Settings (new tab)"**
2. In Elementor Settings tab:
   - Go to **"CPT Support"**
   - Enable **"Team Member"** (check the box)
   - Scroll to **"Disable Default Colors"** - Set to **"Yes"**
   - Scroll to **"Disable Default Fonts"** - Set to **"Yes"**
   - Click **"Save Changes"**
3. Return to wizard tab
4. Click **"✅ Check Settings"**
5. When green box appears: Click **"Next →"**

**Important:**
- All 3 settings must be active
- Check automatically validates all settings

---

### Step 8: Install Styling Plugin (Optional) 🎨

An optional plugin for extended styling options.

**Actions (if available):**
1. Click upload area
2. Upload Styling Plugin ZIP
3. Wait for installation
4. Click **"Next →"**

**If no plugin available:**
- Simply click **"Next →"**

---

### Step 9: Import Demo Data (Optional) 📊

Demo Team Members help you understand the structure.

**⚠️ IMPORTANT - AVOID MULTIPLE IMPORTS:**

**If already imported:**
- You see a **green box** with "✅ Demo data successfully imported!"
- A **green warning** "⚠️ Please do not import again"
- **DO NOT import again** - will create duplicate posts!
- If needed, use **"🔄 Reset"** button FIRST

**Actions (First Import):**
1. Check the checkbox **"Import Demo Team Members"**
2. Upload area appears
3. Upload your demo data XML (e.g., `team-demo.xml`)
4. Wait for confirmation (5-10 seconds)
5. You will see:
   - ✅ **Green notification top-right** (visible 8 seconds)
   - ✅ **Green success box** in step content
   - ✅ **Progress bubble turns green**

**If no demo data wanted:**
- Click **"⏭️ Skip (no demo data)"**

**Progress Bubble:** Turns green after import or after skipping

**Troubleshooting:**
- If accidentally imported twice: Use Reset button

---

### Step 10: Publish Privacy Page 🔒

Publishes the privacy page and sets WordPress settings.

**Actions:**
1. Click **"📄 Publish Privacy Page Now"**
2. Wait for confirmation
3. Click **"Next →"**

**What Happens:**
- Privacy page is published
- WordPress Privacy Policy Page is set
- Imprint is published (if available)

---

### Step 11: Assign Templates 🔗

Assigns Elementor templates to corresponding pages.

**Actions:**
1. Click **"⚙️ Open Theme Builder (new tab)"**
2. In Theme Builder:
   - Assign Header template (Site Header)
   - Assign Footer template (Site Footer)
   - Assign Single Team template (Single → Team Member)
   - Assign Archive Team template (Archive → Team Member)
3. Return to wizard
4. Click **"✅ Done - Templates Assigned"**

**Important:** Don't forget to activate templates (Publish)

---

### Step 12: WordPress Settings 🛠️

Configures basic WordPress settings.

**Actions:**
1. Click **"💾 Set Settings Automatically"**
2. Wait for confirmation
3. Click **"Next →"**

**What Gets Configured:**
- Homepage as front page
- Blog page for posts
- Permalink structure: `/%postname%/`
- Privacy page as WP Privacy Policy

---

### Step 13: Choose Color Scheme 🎨

Select a color scheme for your website.

**Available Schemes:**
- ✨ Template Standard (green tones)
- 🌾 Warm Earth Tones
- 💜 Soft Lavender Tones
- 🌸 Warm Rose Tones
- 🌊 Blue-Gray/Apricot
- 🕊️ Dove Blue/Beige
- 🪻 Soft Mauve

**Actions:**
1. Click a color scheme
2. Scheme is **applied immediately** (no waiting)
3. You see a success notification
4. Progress bubble turns green
5. You can switch between schemes (just click another)
6. Click **"Next →"** when satisfied

**Features:**
- ✅ Instant application (no "Apply" button needed)
- ✅ Sets 10 base colors + 3 hover variants
- ✅ Preview button for each scheme
- ✅ Active scheme marked with green border

**Note:** You can adjust colors later in Elementor Global Colors

---

### Step 14: Choose Fonts 📖

Select a typography scheme for your website.

**Available Schemes:**
- 📖 Template Standard (Instrument Serif + Inter)
- 🎯 Modern Sans (Inter)
- ✨ Elegant Serif (Playfair Display + Inter)
- 😊 Warm & Friendly (Outfit + Inter)
- 💼 Professional (Montserrat + Inter)

**Actions:**
1. Click **"🔤 Prepare Fonts"**
   - Reloads custom fonts
   - Activates Google Fonts locally (GDPR compliant)
2. Click a typography scheme
3. Scheme is applied immediately
4. Progress bubble turns green
5. Click **"Next →"**

**What Gets Set:**
- Primary Font (headings)
- Secondary Font
- Text Font (body text)
- Accent Font
- Small Text Font
- Number Big Font
- Quote Font

---

### Step 15: Button & Image Styles (Optional) 🎭

Defines global styles for buttons and images.

**Available Schemes:**
- 🎨 Template Standard
- 🔷 Modern Minimal
- ✨ Elegant Rounded
- 🎯 Bold & Clear

**Actions:**
1. Click a style scheme (optional)
2. Scheme is applied immediately
3. Or click **"Continue (keep styles)"**

**Note:** This step is completely optional

---

### Step 16: Setup Complete! 🎉

Congratulations! Your setup is complete.

**Next Steps:**
1. Click **"🎨 Go to Theme Builder"** - Fine-tune templates
2. Click **"📝 Manage Team Members"** - Create your own team members
3. Or go directly to **Website View**

**What You Have Now:**
- ✅ Fully configured WordPress installation
- ✅ Elementor with activated Pro license
- ✅ Imported templates and pages
- ✅ Configured Team Member structure
- ✅ Global colors and fonts
- ✅ Assigned templates
- ✅ WordPress basic settings

---

## ⚠️ Important Notes

### 🚨 Avoid Multiple Imports

**Step 9 (Demo Data):**
- ⚠️ **DO NOT import multiple times!**
- If green success box is shown, data is already imported
- Multiple imports create duplicate posts → can cause errors
- If needed: Click **"🔄 Reset"** first, then import again

**Step 5 (Template Kit):**
- Template kits should only be imported ONCE
- Re-importing can cause conflicts

### 💾 Status Saving

The wizard automatically saves your progress:
- ✅ Completed steps are marked (green bubbles)
- ✅ You can leave and resume anytime
- ✅ Welcome page shows "Continue" card

### 🔄 Restart

To start from scratch:
- Delete option `psycho_wizard_status` in database
- Or use recovery tool (if available)

### 🌐 Browser Compatibility

Recommended browsers:
- ✅ Chrome/Edge (latest version)
- ✅ Firefox (latest version)
- ✅ Safari (latest version)
- ⚠️ Internet Explorer is NOT supported

---

## 🔧 Troubleshooting

### Problem: Progress Bubble Doesn't Turn Green

**Step 5 (Template Kit):**
- **Cause:** Templates not yet imported or not detected
- **Solution:**
  1. Check in Elementor tab if import is really complete
  2. Click "🔄 Check Import Status"
  3. Reload wizard page (F5)

**Step 9 (Demo Data):**
- **Solution:** Reload page (F5)
- Status is detected automatically on load

### Problem: Notification Not Displayed (Step 9)

**Causes:**
1. JavaScript error in browser
2. Browser cache

**Solution:**
1. Open browser console (F12)
2. Look for error messages (red)
3. Reload page with Ctrl+Shift+R (Hard Reload)
4. Check if you see these logs:
   ```
   showNotification called: success, [Message]
   Notification added to DOM
   Notification setup complete
   ```

### Problem: Upload Fails

**Possible Causes:**
- File too large
- Wrong file format
- Server timeout
- PHP Memory Limit too low

**Solution:**
1. Check file format (ZIP for plugins/kits, XML for demo data)
2. Check file size (max 50MB)
3. Increase PHP Memory Limit to 256MB or higher
4. Contact your hosting provider

### Problem: Elementor Pro License Not Recognized

**Solution:**
1. Activate license DIRECTLY on Elementor Pro page
2. Wait 5-10 seconds
3. Return to wizard
4. Click "🔄 Check License Status"
5. If still not active: Check your license key

### Problem: Theme Builder Templates Don't Appear

**Cause:** Template Kit not yet imported

**Solution:**
1. Go back to Step 5
2. Import Template Kit
3. Return to Step 11

### Problem: ACF Fields Not Displayed

**Cause:** ACF plugin not installed or fields not imported

**Solution:**
1. Check if ACF Pro is installed and activated
2. Re-import ACF JSON file (Step 6)
3. Go to ACF → Field Groups and check if "Team Member" group exists

---

## ❓ FAQ

### Can I run the wizard multiple times?

Yes, but carefully:
- ⚠️ Avoid multiple imports (Step 5, Step 9)
- ✅ Colors, fonts and styles can be changed anytime
- ⚠️ Template assignments overwrite previous settings

### Can I skip individual steps?

- Yes, most steps can be skipped
- ⚠️ **Required steps:** 1-4 (Hello Theme, Elementor, Elementor Pro)
- ⚠️ Without Template Kit (Step 5) templates are missing
- ⚠️ Without ACF (Step 6) Team Member fields are missing

### What happens if I close the wizard?

- ✅ Your progress is saved automatically
- ✅ Completed steps stay green
- ✅ You can continue anytime (Welcome Page → "Continue")

### How long are notifications visible?

- 8 seconds (automatic disappear)
- You can see multiple notifications simultaneously
- Notifications appear top-right

### Can I change colors/fonts later?

Yes, absolutely:
- **Colors:** Elementor → Site Settings → Global Colors
- **Fonts:** Elementor → Site Settings → Custom Fonts / Typography
- **Styles:** Elementor → Site Settings → Buttons / Images

### What happens on errors during import?

- ❌ Red error notification is displayed
- ❌ Step is NOT marked as completed
- ✅ You can retry the import
- ✅ Check browser console (F12) for details

### How can I delete demo data again?

1. Go to Step 9
2. Click **"🔄 Reset Demo Data"**
3. Confirm action
4. All demo Team Members are deleted
5. You can re-import (if desired)

### Will my data be overwritten?

**No, if you're careful:**
- ✅ Fresh installation → No data to overwrite
- ⚠️ With existing content: Avoid multiple imports
- ⚠️ Template assignments overwrite previous assignments

### Can I use the wizard on a live site?

- ⚠️ **Not recommended** on production sites
- ✅ Better: Staging environment or fresh WordPress installation
- ⚠️ Templates and settings will be overwritten

---

## ⏱️ Waiting Badge Management

After completing the setup, you have access to a **Waiting Badge Feature** that allows you to prominently display your current waiting time on the website.

### Access Settings

1. WordPress Admin → **Setup Wizard → ⏱️ Waiting Badge**

### Features

**Enable/disable badge:**
- Toggle switch to turn on/off
- Instantly visible/invisible on website

**Customizable texts:**
- **Heading:** e.g., "Waiting time", "Wartezeit", "Availability"
- **Time:** e.g., "8-10 weeks", "6-8 Wochen", "Available now"

**Choose position:**
- Bottom Left or Bottom Right
- Fixed position (scrolls with page)

**Cookie duration:**
- Determines how long the badge stays hidden after being closed (1-365 days)

### Elementor Integration

The Waiting Badge is fully styled in Elementor:

**1. Create badge container (Section/Container):**
- Add CSS class: `waiting-badge-container`

**2. Insert texts via shortcodes:**
- Heading Widget: `[waiting_badge_heading]`
- Heading Widget: `[waiting_badge_time]`

**3. Add close button:**
- Icon Widget with CSS class: `waiting-badge-close`

**4. Colors automatically:**
- All Elementor Global Colors are automatically used

### Show/Hide Logic

**Automatic visibility control:**
- Badge is ONLY displayed when enabled in settings
- No Elementor Display Conditions needed!
- Cookie-based hiding after close click

**Body classes:**
- `waiting-badge-enabled` - Badge is active
- `waiting-badge-disabled` - Badge is inactive

### Export / Import

**Export settings:**
- Perfect for Template Kits!
- JSON file with all badge settings
- Contains: texts, position, cookie duration, activation status

**Import settings:**
- Upload JSON file
- All settings are applied

**Use in Template Kits:**
1. Design badge in Elementor (with correct CSS classes)
2. Export settings (JSON file)
3. Pack in Template Kit ZIP
4. On installation: Import JSON → Badge works immediately!

### Technical Details

**JavaScript:**
- Cookie management
- Close button function
- Fade-out animation
- ESC key to close
- Responsive (smaller badge on mobile)

**Position:**
- Fixed positioning via JavaScript
- Overrides Elementor position
- Z-Index: 9999 (always in foreground)

### Example Setup

1. **Open Elementor** (any page)
2. **Add Container** (Fixed Position)
3. **Set CSS class:** `waiting-badge-container`
4. **Add Heading:** `[waiting_badge_heading]`
5. **Add Heading:** `[waiting_badge_time]`
6. **Add Icon** with class: `waiting-badge-close`
7. **Colors & Styles** via Elementor Global Colors
8. **Save as Template** (Optional: Add to Header/Footer)

### Frequently Asked Questions

**Do I need to set Display Conditions in Elementor?**
- No! The badge is automatically shown/hidden via PHP/JS

**Can I have multiple badges?**
- No, only one badge per site (cookie name is hardcoded)

**What happens when I disable the badge?**
- Badge is immediately hidden on the entire website
- No changes needed in Elementor

**How do I change the design?**
- Edit in Elementor template (colors, fonts, padding, etc.)
- Settings only change texts and position

**Does this work with caching?**
- Yes! Cookie check runs client-side (JavaScript)
- No server-side rendering needed

---

## 📞 Support

For questions or problems:

1. **Check this guide** - Most questions are answered here
2. **Browser Console** (F12) - Shows technical errors
3. **WordPress Debug Log** - Enable WP_DEBUG for details
4. **Contact your administrator** - For technical issues

---

## ✅ Checklist: Successful Setup

After completion you should have:

- [ ] Hello Theme is active
- [ ] Elementor is installed and activated
- [ ] Elementor Pro is installed with active license
- [ ] Template Kit is imported (templates + pages present)
- [ ] ACF fields are imported (Team Member field group exists)
- [ ] Team Settings are configured (CPT Support, schemas disabled)
- [ ] Demo data is imported (optional)
- [ ] WordPress settings are set (homepage, permalinks)
- [ ] Templates are assigned (header, footer, singles)
- [ ] Colors are chosen (Global Colors)
- [ ] Fonts are chosen (Custom Fonts)
- [ ] All progress bubbles are green (except optional steps)

**If all points are fulfilled: Congratulations! 🎉**

Your psychotherapy website is ready for content!

---

*Last updated: 2025*
*Version: 1.0*
