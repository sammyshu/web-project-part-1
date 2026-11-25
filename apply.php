<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Apply online for a role at MatchFit Sports &amp; Fitness Network.">
  <meta name="author" content="Group 7 - COS10026">
  <title>Apply | MatchFit Sports</title>
  
  <link rel="stylesheet" href="styles/style.css">

  <!-- Embedded CSS -->
  <style>
    .skip-link {
      position: absolute;
      left: -10000px;
      top: auto;
      width: 1px;
      height: 1px;
      overflow: hidden;
    }
    .skip-link:focus {
      position: static;
      width: auto;
      height: auto;
      background-color: #4231FF;
      color: white;
      padding: 10px;
      text-decoration: none;
      font-weight: bold;
      display: block;
      text-align: center;
    }
  </style>
</head>

<body>
  <a class="skip-link" href="#main-content">Skip to main content</a>

<?php include __DIR__ . '/header.inc'; ?>


  <main id="main-content">
    <div class="container">

      <section class="apply-intro" aria-labelledby="apply-heading">
        <h1 id="apply-heading">Apply to join MatchFit</h1>
        <p>Use this form to apply for any current vacancy. Your reference number is
           shown on each job advertisement &mdash; you can find it on our
           <a href="jobs.html">Jobs page</a>.</p>
        <p class="required-note">
          Fields marked <span class="required" aria-hidden="true">*</span> are required.
        </p>
      </section>

      <section aria-labelledby="form-heading">
        <h2 id="form-heading">Application form</h2>

        <!-- Inline CSS -->
        <p class="privacy-note" style="font-size: 0.95rem; color: #3D343A;">
          We collect the information on this form only to assess your application. 
          It is stored securely, not shared with third parties, and deleted after 12 months. 
          If you have questions about how your information is handled, contact
          <a href="mailto:careers@matchfit.com.au">careers@matchfit.com.au</a>.
        </p>

        <form class="apply-form" action="process_eoi.php" method="post" novalidate>

          <div class="form-field">
            <label for="job-ref">Job reference number <span class="required">*</span></label>
            <input type="text" id="job-ref" name="job_ref"  maxlength="5" placeholder="e.g. MF204" autocomplete="off">
          </div>

          <div class="form-field">
            <label for="first-name">First name <span class="required">*</span></label>
            <input type="text" id="first-name" name="first_name" maxlength="20" autocomplete="given-name" >
          </div>

          <div class="form-field">
            <label for="last-name">Last name <span class="required">*</span></label>
            <input type="text" id="last-name" name="last_name" maxlength="20" autocomplete="family-name" >
          </div>

          <div class="form-field">
            <label for="dob">Date of birth (dd/mm/yyyy) <span class="required">*</span></label>
            <input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" >
          </div>

          <fieldset class="form-field form-field--full">
            <legend>Gender <span class="required">*</span></legend>
            <div class="choice-group">
              <label><input type="radio" name="gender" value="male" > Male</label>
              <label><input type="radio" name="gender" value="female"> Female</label>
            </div>
          </fieldset>

          <div class="form-field form-field--full">
            <label for="street">Street address <span class="required">*</span></label>
            <input type="text" id="street" name="street" maxlength="40" autocomplete="address-line1">
          </div>

          <div class="form-field">
            <label for="suburb">Suburb or town <span class="required">*</span></label>
            <input type="text" id="suburb" name="suburb" maxlength="40" autocomplete="address-level2">
          </div>

          <div class="form-field">
            <label for="state">State <span class="required">*</span></label>
            <select id="state" name="state">
              <option value="">Select a state</option>
              <option value="VIC">VIC</option>
              <option value="NSW">NSW</option>
              <option value="QLD">QLD</option>
              <option value="NT">NT</option>
              <option value="WA">WA</option>
              <option value="SA">SA</option>
              <option value="TAS">TAS</option>
              <option value="ACT">ACT</option>
            </select>
          </div>

          <div class="form-field">
            <label for="postcode">Postcode <span class="required">*</span></label>
            <input type="text" id="postcode" name="postcode" maxlength="4"  autocomplete="postal-code">
          </div>

          <div class="form-field">
            <label for="email">Email address <span class="required">*</span></label>
            <input type="text" id="email" name="email"  placeholder="you@example.com" autocomplete="email">
          </div>

          <div class="form-field">
            <label for="phone">Phone number <span class="required">*</span></label>
            <input type="text" id="phone" name="phone"  autocomplete="tel">
          </div>

          <fieldset class="form-field form-field--full">
            <legend>Skills <span class="required">*</span></legend>
            <div class="choice-group">
              <label><input type="checkbox" name="skills[]" value="html-css" > HTML and CSS</label>
              <label><input type="checkbox" name="skills[]" value="javascript" > JavaScript</label>
              <label><input type="checkbox" name="skills[]" value="ui-design" > UI and UX Design</label>
              <label><input type="checkbox" name="skills[]" value="database" > Database and SQL</label>
              <label><input type="checkbox" name="skills[]" value="content" > Content writing</label>
              <label><input type="checkbox" name="skills[]" value="project-management" > Project management</label>
            </div>
          </fieldset>

          <div class="form-field form-field--full">
            <label for="other-skills">Other skills or experience (optional)</label>
            <textarea id="other-skills" name="other_skills" rows="4"></textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Submit application</button>
          </div>
        </form>
      </section>

      <section class="next-steps" aria-labelledby="next-heading">
        <h2 id="next-heading">What happens next</h2>
        <ol>
          <li>We acknowledge your application within two business days.</li>
          <li>Shortlisted applicants have a 20-minute phone conversation.</li>
          <li>Final interviews are held at our Hawthorne office or online.</li>
          <li>All applicants receive an outcome, successful or not.</li>
        </ol>
      </section>

    </div>
  </main>

<?php include __DIR__ . '/footer.inc'; ?>

</body>
</html>