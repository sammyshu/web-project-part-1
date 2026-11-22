


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Meet the team behind the MatchFit website"/>
    <meta name="author" content="Group 7"/>
    <link rel="stylesheet" href="styles/style.css">
    <title>About Us | MatchFit Sports</title>

    <!-- Page-specific styles -->
    <style>
        /* Styling the Student ID Badge */
        .student-id {
            background-color: var(--logo-blue);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-left: 10px;
        }

        /* Styling the Group Photo */
        .group-photo {
            text-align: center;
            margin: 3rem 0;
        }
        .group-photo img {
            border-radius: 16px;
            border: 4px solid white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 100%;
            height: auto;
        }
        .group-photo figcaption {
            margin-top: 1rem;
            font-style: italic;
            color: #606060;
        }

    </style>
</head>
<body>

<?php require_once __DIR__ . '/header.inc'; ?>

    <main id="main-content">
        <div class="container">
            <h1 style="text-align: center; margin-top: 2rem;">About Our Team</h1>
            <p style="text-align: center; max-width: 800px; margin: 0 auto 3rem auto;">
                We are Group 7, the minds behind the MatchFit Sports website. We worked together to design, build, and test a complete web experience.
            </p>

            <section aria-labelledby="group-heading">
                <h2 id="group-heading">Group details</h2>
                <ul>
                    <li><strong>Group:</strong> G7
                        <ul>
                            <li><strong>Class day/time:</strong> Sundays and Tuesdays at 9:00 AM</li>
                            <li><strong>Unit:</strong> COS10026 Web Technology Project, Study Period 3 2026</li>
                        </ul>
                    </li>
                </ul>
            </section>

            <!-- Group Photo -->
            <figure class="group-photo">
                <!-- Group photo -->
                <img src="images/group_picture.jpeg" alt="A photo of Group 7 all together" width="500" height="360">
                <figcaption>Group 7 - The MatchFit Team</figcaption>
            </figure>

            <!-- Member Contributions and Quotes (All Arabic) -->
            <section aria-labelledby="members-heading">
                <h2 id="members-heading">Contributions</h2>
                <?php if ($members): ?>
             <!-- TODO: Loop through the members and display their contributions -->
                <?php else: ?> <!-- Fall back -->


                <dl>
                    <!-- Mayasa -->
                    <dt>Mayasa <span class="student-id">ID: 106242824</span></dt>
                    <dd>Built and styled the Apply page (apply.html), focusing on form layout, accessibility, and responsive design.</dd>
                    <dd>
                        <blockquote>
                            <p lang="ar">العمل الجماعي هو مفتاح النجاح</p>
                            <p>"Teamwork is the key to success" (English Translation)</p>
                        </blockquote>
                    </dd>

                    <!-- Sammy -->
                    <dt>Sammy <span class="student-id">ID: 106687632</span></dt>
                    <dd>Designed and built the Home page (index.html), established page design, maintained the Jira project, and led other members to assure quality.</dd>
                    <dd>
                        <blockquote>
                            <p lang="ar">اليد الواحدة لا تصفق</p>
                            <p>"One hand doesn't clap" (English Translation)</p>
                        </blockquote>
                    </dd>

                    <!-- Ziad -->
                    <dt>Ziad <span class="student-id">ID: 106218139</span></dt>
                    <dd>Developed the About page (about.html), compiled the team's information, and ensured semantic HTML structure.</dd>
                    <dd>
                        <blockquote>
                            <p lang="ar">التكنولوجيا تربطنا جميعاً</p>
                            <p>"Technology connects us all" (English Translation)</p>
                        </blockquote>
                    </dd>

                    <!-- Adam -->
                    <dt>Adam <span class="student-id">ID: 106197830</span></dt>
                    <dd>Built the Jobs page (jobs.html), structuring the job listings and ensuring a seamless user experience.</dd>
                    <dd>
                        <blockquote>
                            <p lang="ar">البرمجة تبني المستقبل</p>
                            <p>"Programming builds the future" (English Translation)</p>
                        </blockquote>
                    </dd>
                </dl>
<?php endif; ?>
            </section>
            <section aria-labelledby="table-heading"> 
                <h2 id="table-heading">Fun Facts</h2>
                <div class="table-scroll">
                <table class="data-table">
                    <caption>Getting to know Group 7</caption>
                    <thead>
                        <tr>
                            <th scope="col">Member</th>
                            <th scope="col">Favourite Sport</th>
                            <th scope="col">Dream Job</th>
                            <th scope="col">Coffee or Tea?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Mayasa</th>
                            <td>Tennis</td>
                            <td>Web Developer</td>
                            <td>Tea</td>
                        </tr>
                        <tr>
                            <th scope="row">Sammy</th>
                            <td>Basketball</td>
                            <td>Systems Infrastructure Engineer</td>
                            <td>Iced Coffee</td>
                        </tr>
                        <tr>
                            <th scope="row">Ziad</th>
                            <td>Football</td>
                            <td>Cybersecurity Analyst</td>
                            <td>Coffee</td>
                        </tr>
                        <tr>
                            <th scope="row">Adam</th>
                            <td>Swimming</td>
                            <td>Data Scientist</td>
                            <td>Green Tea</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </section>

            <p style="text-align: center; font-style: italic; color: #606060; margin: 3rem 0;">
                Thanks for getting to know Group 7!
            </p>

        </div>
    </main>
        <?php require __DIR__ . '/footer.inc'; ?>
</body>
</html>