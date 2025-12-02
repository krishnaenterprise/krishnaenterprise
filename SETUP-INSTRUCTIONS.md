# Krishna Enterprise - Contact Form Setup Instructions

## 📋 What Was Created

1. **submit-form.php** - Backend script that receives and stores form submissions
2. **view-messages.php** - Admin panel to view all received messages
3. **messages.json** - Database file (will be created automatically when first message is submitted)

## 🚀 Setup Instructions

### Option 1: Local Testing (XAMPP/WAMP/MAMP)

1. **Install a local PHP server:**
   - Download XAMPP: https://www.apachefriends.org/
   - Or WAMP: https://www.wampserver.com/
   - Or MAMP: https://www.mamp.info/

2. **Move files to web server:**
   - Copy all files to your web server directory:
     - XAMPP: `C:\xampp\htdocs\krishna-enterprise\`
     - WAMP: `C:\wamp64\www\krishna-enterprise\`
     - MAMP: `/Applications/MAMP/htdocs/krishna-enterprise/`

3. **Start the server:**
   - Open XAMPP/WAMP/MAMP Control Panel
   - Start Apache

4. **Access your website:**
   - Open browser: `http://localhost/krishna-enterprise/krishna1.html`

### Option 2: Live Hosting (Recommended)

1. **Upload to your web hosting:**
   - Use FTP/cPanel File Manager
   - Upload all files to your public_html or www directory

2. **Set file permissions:**
   - Set `messages.json` to 666 (read/write) - it will be created automatically
   - Set `submit-form.php` to 644
   - Set `view-messages.php` to 644

3. **Test the form:**
   - Visit your website
   - Fill out the contact form
   - Submit and check for success message

## 🔐 Admin Panel Access

1. **Access the admin panel:**
   - Go to: `http://your-domain.com/view-messages.php`
   - Or locally: `http://localhost/krishna-enterprise/view-messages.php`

2. **Default password:** `krishna2024`
   - **IMPORTANT:** Change this password in `view-messages.php` line 5

3. **View messages:**
   - See all submitted messages
   - Click WhatsApp button to chat directly
   - Click Email button to reply via email

## 📧 Email Notifications (Optional)

To receive email notifications when someone submits the form:

1. Open `submit-form.php`
2. Find line 62: `$to = 'your-email@example.com';`
3. Replace with your actual email address
4. Uncomment line 71: Remove `//` from `// mail($to, $subject, $emailBody, $headers);`

**Note:** Email functionality requires your server to have mail() function configured.

## 🔒 Security Recommendations

1. **Change admin password:**
   - Edit `view-messages.php` line 5
   - Use a strong password

2. **Protect admin panel:**
   - Add `.htaccess` password protection
   - Or move to a hidden URL

3. **Backup messages:**
   - Regularly download `messages.json`
   - Keep backups of customer inquiries

4. **File permissions:**
   - Ensure `messages.json` is not publicly accessible
   - Add to `.htaccess`:
     ```
     <Files "messages.json">
       Order Allow,Deny
       Deny from all
     </Files>
     ```

## 📱 Features

### Contact Form:
- ✅ Stores all submissions in JSON database
- ✅ Validates email and required fields
- ✅ Shows success/error messages
- ✅ Prevents duplicate submissions
- ✅ Mobile responsive

### Admin Panel:
- ✅ View all messages
- ✅ See statistics (total, today, this week)
- ✅ Direct WhatsApp link for each inquiry
- ✅ Email reply button
- ✅ Shows product interest
- ✅ Timestamp for each message
- ✅ Password protected

## 🐛 Troubleshooting

**Form not submitting:**
- Check if PHP is running
- Check browser console for errors
- Verify `submit-form.php` path is correct

**Messages not saving:**
- Check folder write permissions
- Ensure PHP has permission to create files
- Check PHP error logs

**Can't access admin panel:**
- Verify password is correct
- Check if sessions are enabled in PHP
- Clear browser cookies

## 📞 Support

If you need help:
1. Check PHP error logs
2. Verify all files are uploaded
3. Test with a simple PHP info file: `<?php phpinfo(); ?>`

## 🎉 You're All Set!

Your contact form is now fully functional and will store all customer inquiries in a simple JSON database. Access the admin panel anytime to view and respond to messages!
