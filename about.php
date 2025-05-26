<?php include("header.inc"); ?>
<?php include("nav.inc"); ?>

<main class="about-container">
  <h1>About Our Team</h1>

  <!-- Group Info -->
  <section class="basic-info">
    <h2>Group Information</h2>
    <dl>
      <dt>Group Name:</dt>
      <dd>Web Techs</dd>

      <dt>Group ID:</dt>
      <dd>#6</dd>

      <dt>Tutor's Name:</dt>
      <dd>Nick</dd>
    </dl>
  </section>

  <!-- Team Photos -->
  <section class="team-photo">
    <h2>Our Team</h2>
    <div class="team-photos-container">
      <figure class="member-photo">
        <img src="images/Senaya.jpg" alt="Senaya Siriwardana" />
        <figcaption>Senaya Siriwardana</figcaption>
      </figure>
      <figure class="member-photo">
        <img src="images/Navod.jpg" alt="Navod Pallawattage" />
        <figcaption>Navod Pallawattage</figcaption>
      </figure>
      <figure class="member-photo">
        <img src="images/Druv.jpg" alt="Dhruv Narola" />
        <figcaption>Dhruv Narola</figcaption>
      </figure>
    </div>
  </section>

  <!-- Contributions -->
  <section class="contributions">
    <h2>Member Contributions (Part 2)</h2>
    <dl>
      <dt>Senaya Siriwardana</dt>
      <dd>
        Created and validated <code>apply.php</code> and <code>process_eoi.php</code>, implemented EOI database logic, handled form sanitation, and created enhancements and about pages.
      </dd>

      <dt>Navod Pallawattage</dt>
      <dd>
        Designed the <code>index.php</code>, refactored all headers/footers into <code>.inc</code> files, and managed MySQL table creation and testing via phpMyAdmin.
      </dd>

      <dt>Dhruv Narola</dt>
      <dd>
        Developed <code>jobs.php</code> and job detail pages dynamically from the database, and contributed styling/UI improvements across the site.
      </dd>
    </dl>
  </section>

 
  <!-- Contact -->
  <section class="contact">
    <h2>Contact Our Team</h2>
    <a href="mailto:105098518@student.swin.edu.au">Web Techs</a>
  </section>
</main>

<?php include("footer.inc"); ?>
