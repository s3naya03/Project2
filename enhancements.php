<?php include("header.inc"); ?>
<?php include("nav.inc"); ?>
<main class="enhancement-container">
  <h1>Enhancements Implemented</h1>

  <section>
    <h2>1. EOI Sorting by Field</h2>
    <p>
      In the <code>manage.php</code> page, a dropdown was added allowing HR managers to
      sort the list of EOIs by fields such as EOInumber, job reference, or applicant name. The selection dynamically affects the SQL query.
    </p>
  </section>

  <section>
    <h2>2. Manager Registration with Validation</h2>
    <p>
      A secure registration system was implemented in <code>register.php</code> to create manager accounts. It enforces unique usernames and strong password rules, storing hashed passwords securely in the database.
    </p>
  </section>

  <section>
    <h2>3. Restricted Access to manage.php</h2>
    <p>
      The <code>manage.php</code> page uses PHP sessions to ensure only authenticated users can access the EOI management dashboard.
    </p>
  </section>

  <section>
    <h2>4. Login Lockout after Failed Attempts</h2>
    <p>
      The <code>login.php</code> file includes a login throttling mechanism. If a user enters the wrong password 3 times, the system disables login access for 10 minutes to protect against brute-force attacks.
    </p>
  </section>
</main>
<?php include("footer.inc"); ?>
