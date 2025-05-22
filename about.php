<?php include("header.inc"); ?>
<?php include("nav.inc"); ?>

    <main class="about-container">
      <h1>About Our Team</h1>

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

      <section class="team-photo">
        <h2>Our Team</h2>
        <div class="team-photos-container">
          <figure class="member-photo">
            <img src="images/Senaya.jpg" alt="[Member 1 Name]" />
            <figcaption>Senaya Siriwardana</figcaption>
          </figure>
          <figure class="member-photo">
            <img src="images/Navod.jpg" alt="[Member 2 Name]" />
            <figcaption>Navod Pallawattage</figcaption>
          </figure>
          <figure class="member-photo">
            <img src="images/Druv.jpg" alt="[Member 3 Name]" />
            <figcaption>Dhruv Narola</figcaption>
          </figure>
        </div>
      </section>

      <section class="contributions">
        <h2>Member Contributions</h2>
        <dl>
          <dt>Senaya Siriwardana</dt>
          <dd>
            Developed the apply.html, search.html, about.html, enhancements.html
            and validation
          </dd>

          <dt>Navod Pallawattage</dt>
          <dd>Designed the index.html and about.html</dd>

          <dt>Dhruv Narola</dt>
          <dd>Created the jobs.html and choicejob.html</dd>
        </dl>
      </section>

      <section class="timetable">
        <h2>Our Shared Timetable</h2>
        <table>
          <thead>
            <tr>
              <th>Day</th>
              <th>Time</th>
              <th>Unit</th>
              <th>Location</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Monday</td>
              <td>10:00-12:00</td>
              <td>COS10011</td>
              <td>ATC620</td>
            </tr>
            <tr>
              <td>Tuesday</td>
              <td>14:00-16:00</td>
              <td>COS60004</td>
              <td>ATC620</td>
            </tr>
            <tr>
              <td>Wednesday</td>
              <td>11:00-13:00</td>
              <td>COS60007</td>
              <td>ATC620</td>
            </tr>
            <tr>
              <td>Thursday</td>
              <td>09:00-11:00</td>
              <td>COS10011 Lab</td>
              <td>EN101</td>
            </tr>
          </tbody>
        </table>
      </section>

      <section class="profiles">
        <h2>Team Profiles</h2>

        <article class="profile">
          <h3>Senaya Siriwardana</h3>
          <p><strong>Skills:</strong> HTML, CSS, JavaScript</p>
          <p><strong>Hometown:</strong> Colombo, Sri Lanka</p>
          <p><strong>Interests:</strong> Web design, photography, hiking</p>
          <p><strong>Favorite Film:</strong>Stranger Things</p>
        </article>

        <article class="profile">
          <h3>Navod Pallawattage</h3>
          <p><strong>Skills:</strong> Python, Java, SQL</p>
          <p><strong>Hometown:</strong> Colombo, Sri Lanka</p>
          <p><strong>Interests:</strong> Gaming, music, travel</p>
          <p><strong>Favorite Film:</strong>Fast and Furious</p>
        </article>

        <article class="profile">
          <h3>Dhruv Narola</h3>
          <p><strong>Skills:</strong> UI/UX Design, Graphic Design</p>
          <p><strong>Hometown:</strong> Panjab, India</p>
          <p><strong>Interests:</strong> Art, photography, cooking</p>
          <p><strong>Favorite Film:</strong> Happy New Year</p>
        </article>
      </section>

      <section class="contact">
        <h2>Contact Our Team</h2>
        <a href="mailto:105098518@student.swin.edu.au">Web Techs</a>
      </section>
    </main>

    <?php include("footer.inc"); ?>
