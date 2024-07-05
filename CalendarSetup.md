## Setting Up and Using the Calendar Feature

The calendar feature in our Learning Management System (LMS) allows you to schedule and manage one-on-one and batch sessions conveniently. Follow the instructions below to set up and use the calendar feature effectively.

### One-on-One Meet Session

1. **Creating a Session:**
   - Go to **Students** > **Manage** > **Meetings**.
   - Add a new session with the following parameters:
     - **Title**: Enter the title of the session.
     - **Start Date/Time**: Set the start date and time for the session.
     - **End Date/Time**: Set the end date and time for the session.
     - **Description** (optional): Provide additional information about the session.
     - **Add Meeting Link** (checkbox): Check this box to add a meeting link.
     - **Notify Attendee** (checkbox): Check this box to send notifications (default: enabled).

2. **Email Notification:**
   - After saving the session, you and the student will receive an email notification with the session details.

### Batch Session

1. **Creating a Batch Session:**
   - Go to **Batch** > **Preview**.
   - Create a new session with the same fields as mentioned above.
   - On saving, all students in the batch will be invited to the session, and it will be added to their calendars.

### Separate Calendars (Admin)

1. **Adding Calendar ID:**
   - Admins can go to their **Profile** to add a calendar ID.
   - Ensure to link the calendar, invite the service account "lms-event@lms-dev-397014.iam.gserviceaccount.com" and assign permission to "make changes to events".
   - Note: These calendars must be linked to "info@guardianscorporate.co.uk".

2. **Obtaining Google Calendar ID:**
   - In the Google Calendar interface, find the "My calendars" section on the left.
   - Hover over the calendar and click the downward arrow.
   - Click "Calendar settings".
   - In the "Calendar Address" section, find your Calendar ID (e.g., "abcd1234@group.calendar.google.com").

3. **Separate Calendars Usage:**
   - New events will save to the default calendar, except when the admin has a calendar ID added to their profile.
   - When separate calendars are used, students might not see scheduled sessions on the LMS but will see them on their individual calendar and receive email notifications.

Remember, our calendar feature simplifies scheduling and ensures that both students and admins are well-informed about upcoming sessions.

---


## Using Different Google Account for Calendar Feature

To use a different account for the calendar feature in our Learning Management System (LMS), follow these steps. This allows you to manage events and sessions using a dedicated calendar.

### Generating a Service Account

1. Go to [Google Cloud Console](https://console.cloud.google.com/).
2. Create a new project or select an existing one.
3. Enable the Google Calendar API for the project.
4. Create a new service account within the project.
5. Download the JSON key file for the service account. This file will be used for authentication.

### Domain-Wide Delegation

1. Log in to your [Google Admin Console](https://admin.google.com/) with your G Suite account.
2. Navigate to **Security** > **API Controls** > **Domain-wide Delegation**.
3. Click on "Add new".
4. Enter the client ID of your service account (the one with only numbers).
5. Set the following scopes:
   - `https://www.googleapis.com/auth/calendar`
   - `https://www.googleapis.com/auth/calendar.events`
   - `https://www.googleapis.com/auth/admin.directory.resource.calendar`
6. Assign the role "Service Account Token Creator" to the new service account.

### Impersonation and Calendar Setup

1. Navigate to the [Google Cloud Console](https://console.cloud.google.com/iam-admin) and select your project.
2. In the IAM section, find the account you will use to impersonate and click on "Edit".
3. Add the role "Service Account Token Creator".
4. Enable domain delegation for the account as outlined in [this guide](https://developers.google.com/admin-sdk/directory/v1/guides/delegation#enable-domain-wide-delegation).

### Creating a Calendar

1. Log in to [Google Calendar](https://calendar.google.com/) with the email you want to own the calendar.
2. Create a new calendar.
3. Share the calendar with the service account and the impersonated account. Grant permissions to modify and manage the calendar.

### Storing Credentials and Configuration

1. Download the service account JSON key and save it as `service-account-credentials.json` in the `/storage/app/google-calendar/` directory of your LMS.
2. Update your `.env` file with the following:
   ```
   GOOGLE_CALENDAR_AUTH_PROFILE=service_account
   GOOGLE_CALENDAR_ID=YOUR_CALENDAR_ID
   GOOGLE_CALENDAR_IMPERSONATE=EMAIL_TO_IMPERSONATE
   ```

Replace `YOUR_CALENDAR_ID` with the Calendar ID you obtained earlier, and `EMAIL_TO_IMPERSONATE` with the email address you're impersonating.

Using a different calendar allows you to manage events and sessions separately, providing enhanced organization and control over your LMS calendar feature.

For detailed steps, consult the guide [here](https://apps.google.com/supportwidget/articlehome?hl=en&article_url=https%3A%2F%2Fsupport.google.com%2Fa%2Fanswer%2F7378726%3Fhl%3Den&assistant_id=generic-unu&product_context=7378726&product_name=UnuFlow&trigger_context=a).

Remember that these steps may vary based on Google's interface changes. Always refer to the most recent documentation for accurate instructions.
