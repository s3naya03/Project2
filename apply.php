<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>jobLock | Find a job</title>
    <link rel="stylesheet" href="styles/styles.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  </head>
  <body>
    <div class="container">
      <section class="logo">
        <h1>job<span>Lock</span></h1>
        <p>Lock Your Dream Job</p>
      </section>
      <nav>
        <ul class="nav-menu">
          <li class="active"><a href="index.html">Home</a></li>
          <li><a href="search.html">Search Jobs</a></li>
          <li><a href="about.html">About Us</a></li>
          <li><a href="enhancements.html">Enhancements</a></li>
        </ul>
      </nav>
    </div>
    <div class="container">
      <header>
        <h1>Job Application</h1>
      </header>

      <form
        action="https://mercury.swin.edu.au/it000000/formtest.php"
        method="post">
        <fieldset>
          <legend>Personal Details</legend>

          <p>
            <label for="job_ref">Job Reference Number:</label>
            <input
              type="text"
              id="job_ref"
              name="job_ref"
              pattern="[A-Za-z0-9]{5}"
              title="Exactly 5 alphanumeric characters"
              required />
          </p>

          <p>
            <label for="first_name">First Name:</label>
            <input
              type="text"
              id="first_name"
              name="first_name"
              maxlength="20"
              pattern="[A-Za-z]+"
              title="Maximum 20 alphabetic characters"
              required />
          </p>

          <p>
            <label for="last_name">Last Name:</label>
            <input
              type="text"
              id="last_name"
              name="last_name"
              maxlength="20"
              pattern="[A-Za-z]+"
              title="Maximum 20 alphabetic characters"
              required />
          </p>

          <p>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required />
          </p>

          <fieldset>
            <legend>Gender:</legend>
            <p>
              <input
                type="radio"
                id="male"
                name="gender"
                value="Male"
                required />
              <label for="male">Male</label>
            </p>
            <p>
              <input type="radio" id="female" name="gender" value="Female" />
              <label for="female">Female</label>
            </p>
            <p>
              <input type="radio" id="other" name="gender" value="Other" />
              <label for="other">Other</label>
            </p>
          </fieldset>
        </fieldset>

        <fieldset>
          <legend>Contact Information</legend>

          <p>
            <label for="street_address">Street Address:</label>
            <input
              type="text"
              id="street_address"
              name="street_address"
              maxlength="40"
              required />
          </p>

          <p>
            <label for="suburb">Suburb/Town:</label>
            <input
              type="text"
              id="suburb"
              name="suburb"
              maxlength="40"
              required />
          </p>

          <p>
            <label for="state">State:</label>
            <select id="state" name="state" required>
              <option value="">Select State</option>
              <option value="VIC">VIC</option>
              <option value="NSW">NSW</option>
              <option value="QLD">QLD</option>
              <option value="NT">NT</option>
              <option value="WA">WA</option>
              <option value="SA">SA</option>
              <option value="TAS">TAS</option>
              <option value="ACT">ACT</option>
            </select>
          </p>

          <p>
            <label for="postcode">Postcode:</label>
            <input
              type="text"
              id="postcode"
              name="postcode"
              pattern="[0-9]{4}"
              title="Exactly 4 digits"
              required />
          </p>

          <p>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required />
          </p>

          <p>
            <label for="phone">Phone Number:</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              pattern="[0-9 ]{8,12}"
              title="8 to 12 digits or spaces"
              required />
          </p>
        </fieldset>

        <fieldset>
          <legend>Skills</legend>

          <fieldset>
            <legend>Select your skills:</legend>
            <p>
              <input
                type="checkbox"
                id="skill1"
                name="skills[]"
                value="Networking" />
              <label for="skill1">Networking</label>
            </p>
            <p>
              <input
                type="checkbox"
                id="skill2"
                name="skills[]"
                value="Cybersecurity" />
              <label for="skill2">Cybersecurity</label>
            </p>
            <p>
              <input
                type="checkbox"
                id="skill3"
                name="skills[]"
                value="Programming" />
              <label for="skill3">Programming</label>
            </p>
            <p>
              <input
                type="checkbox"
                id="skill4"
                name="skills[]"
                value="Other" />
              <label for="skill4">Other skills...</label>
            </p>
          </fieldset>

          <p>
            <label for="other_skills">Other Skills (please specify):</label>
            <textarea id="other_skills" name="other_skills" rows="4"></textarea>
          </p>
        </fieldset>

        <p>
          <button type="submit" class="btn">Apply</button>
        </p>
      </form>
    </div>
    <footer>
        <section class="container">
          <section class="footer-content">
            <nav class="social-icons" aria-label="Social media links">
              <a href="mailto:105098518@student.swin.edu.au"><i class="fas fa-envelope"></i></i
              ></a>
              <a href="#" aria-label="Twitter"
                ><i class="fab fa-twitter" ></i
              ></a>
              <a href="#" aria-label="LinkedIn"
                ><i class="fab fa-linkedin" ></i
              ></a>
              <a href="#" aria-label="Instagram"
                ><i class="fab fa-instagram" ></i
              ></a>
            </nav>
            <p>&copy; 2023 jobLock. All rights reserved.</p>
          </section>
        </section>
      </footer>
  </body>
</html>
