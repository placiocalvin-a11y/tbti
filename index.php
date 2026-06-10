<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TBTI Philippines | PSSFNS 3</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<style>
:root {
    --primary: #003366; 
    --secondary: #005b96;
    --accent: #d4af37;
    --light-bg: #f4f7f6;
    --white: #ffffff;
}
* { box-sizing: border-box; scroll-behavior: smooth; }
body { font-family: 'Open Sans', sans-serif; margin: 0; background: var(--light-bg); color: #333; line-height: 1.6; }

/* Navigation */
nav { background: var(--white); padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; }
.logo { font-family: 'Montserrat'; color: var(--primary); font-size: 1rem; line-height: 1.2; }
nav ul { list-style: none; display: flex; gap: 12px; margin: 0; padding: 0; flex-wrap: wrap; }
nav ul li a { text-decoration: none; color: var(--primary); font-weight: 600; font-size: 11px; text-transform: uppercase; cursor: pointer; padding: 5px; }
nav ul li a:hover { color: var(--accent); }

/* Hamburger */
.hamburger { display: none; font-size: 1.5rem; cursor: pointer; }

/* Page Handling */
.page { display: none; padding: 60px 10%; min-height: 80vh; }
.page.active { display: block; animation: fadeIn 0.5s; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

/* Banner & Hero */
.banner-card { width: 100%; border-radius: 8px; overflow: hidden; }
.banner-card img { width: 100%; display:block; border-radius:8px; margin-bottom: 20px; }
.hero-text { text-align: center; margin-bottom: 30px; }
.hero-text h1 { color: var(--primary); font-family: 'Montserrat'; margin-bottom:10px; }
.hero-text p { color: #333; margin:5px 0; }

/* Cards & Layout */
.card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 5px solid var(--primary); }
.comp-grid { display: grid; grid-template-columns: 1fr; gap: 30px; margin-top: 20px; }
.comp-header { border-bottom: 2px solid var(--light-bg); padding-bottom: 10px; margin-bottom: 15px; }
.comp-badge { display: inline-block; background: var(--secondary); color: white; padding: 4px 10px; font-size: 12px; font-weight: bold; border-radius: 4px; margin-bottom: 10px; }
.prize-highlight { background: #fffcf0; border: 1px solid #f2e3b6; padding: 15px; border-radius: 6px; margin-top: 15px; margin-bottom: 15px; }

/* Organizer Layout Styles */
.organizer-section { display: flex; align-items: center; gap: 25px; margin-top: 15px; }
.organizer-logo { width: 120px; height: auto; flex-shrink: 0; border-radius: 4px; }
.organizer-text { flex: 1; }

/* Legacy Timeline Custom Styles */
.legacy-timeline { display: flex; flex-direction: column; gap: 15px; margin-top: 25px; }
.timeline-card { background: #fdfdfd; border: 1px solid #eef2f5; border-radius: 6px; padding: 18px; display: flex; gap: 20px; align-items: center; transition: transform 0.2s; }
.timeline-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
.timeline-card.current-host { border-left: 5px solid var(--accent); background: #fffdf9; }
.timeline-aside { text-align: center; min-width: 130px; border-right: 2px solid #eef2f5; padding-right: 15px; }
.timeline-card.current-host .timeline-aside { border-right: 2px solid var(--accent); }
.timeline-tag { font-family: 'Montserrat'; font-size: 1.05rem; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
.timeline-date { font-size: 0.85rem; color: #666; font-weight: 600; margin-top: 2px; }
.timeline-details { flex: 1; font-size: 0.95rem; line-height: 1.5; color: #444; }
.timeline-logo-box { width: 65px; height: 65px; background: #fff; border: 1px solid #eef2f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 6px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.04); }
.timeline-logo-box img { max-width: 100%; max-height: 100%; object-fit: contain; }

/* Buttons */
.btn { background: var(--primary); color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold; margin-top: 10px; border: none; cursor: pointer; text-align: center; }
.btn.secondary { background: var(--secondary); }
.btn-doc { background: #e2e8f0; color: #1a202c; padding: 10px 20px; border-radius: 4px; display: inline-block; font-weight: 600; font-size: 13px; text-decoration: none; margin-top: 15px; border: 1px solid #cbd5e0; transition: background 0.2s; text-align: center; }
.btn-doc:hover { background: #cbd5e0; }

/* Tables */
table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; background: white; font-size: 14px; }
th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
th { background: var(--primary); color: white; }

/* Footer */
footer { background: var(--primary); color: white; text-align: center; padding: 40px; margin-top: 50px; }

/* Countdown */
.countdown-container { text-align:center; font-size:1.2rem; margin-bottom:20px; }

/* Map View Configuration */
#map { height: 480px; width: 100%; margin-top: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 1; }

/* Responsive Adjustments */
@media(max-width:768px) {
    .page{padding:40px 5%;}
    nav ul{gap:6px; display:none; flex-direction:column; width:100%; background: var(--white); position:absolute; top:60px; left:0; padding:10px 0; box-shadow:0 4px 6px rgba(0,0,0,0.1);}
    nav ul.active{display:flex;}
    nav ul li{text-align:center; margin:5px 0;}
    nav ul li a{font-size:10px;}
    .logo{font-size:.9rem;}
    .hero-text h1{font-size:1.2rem;}
    .hero-text p{font-size:0.9rem;}
    .hamburger{display:block;}
    .organizer-section { flex-direction: column; text-align: center; }
    .organizer-logo { width: 100px; margin-bottom: 10px; }
    .timeline-card { flex-direction: column; text-align: center; gap: 12px; padding: 20px 15px; }
    .timeline-aside { border-right: none !important; border-bottom: 2px solid #eef2f5; padding-right: 0; padding-bottom: 10px; width: 100%; }
    .timeline-card.current-host .timeline-aside { border-bottom: 2px solid var(--accent); }
}
</style>
</head>
<body>

<nav>
  <div class="logo">TBTI PHILIPPINES<br><small>National Consortium</small></div>
  <div class="hamburger" onclick="toggleMenu()">☰</div>
  <ul id="nav-links">
    <li><a onclick="showPage('home')">Home</a></li>
    <li><a onclick="showPage('program')">Program</a></li>
    <li><a onclick="showPage('themes')">Themes</a></li>
    <li><a onclick="showPage('abstract')">Abstracts</a></li>
    <li><a onclick="showPage('competition')">Competitions</a></li>
    <li><a onclick="showPage('registration')">Registration</a></li>
    <li><a onclick="showPage('committee')">Committee</a></li>
    <li><a onclick="showPage('partners')">Partners</a></li>
    <li><a onclick="showPage('hotels')">Hotels</a></li>
    <li><a onclick="showPage('proceeding')">Proceeding</a></li>
  </ul>
</nav>

<div id="home" class="page active">
    <div class="banner-card">
        <img src="https://tbtiphpssfns.upv.edu.ph/wp-content/uploads/2024/05/Banner-5_no-backgorund.png" alt="Symposium Banner">
    </div>
    <div class="hero-text">
        <h1>Third Philippine Small-Scale Fisheries National Symposium</h1>
        <p>Theme: “From Action to Replication: Scaling Up and Deepening the Impact of Small-Scale Fisheries”</p>
        <p>October 21-23, 2026 | Batangas State University, Batangas City, Luzon</p>
    </div>

    <div class="countdown-container">
        <p>Registration closes in:</p>
        <div id="countdown"></div>
    </div>
    
    <div class="card">
        <h2>About Us</h2>
        <p>The Philippine Small-Scale Fisheries National Symposium (PSSFNS) is organized through a rotational hosting arrangement among forty-eight (48) state colleges and universities offering Fisheries programs in the Philippines. This collaborative approach promotes national cooperation, strengthens nationwide participation, and encourages wider regional engagement in fisheries research, education, and policy dialogue.</p>
        <p>As a premier platform, the symposium brings together researchers, policymakers, fisheries practitioners, and representatives from small-scale fishing communities to exchange knowledge, share innovative research findings, and discuss strategic actions for the sustainability and governance of small-scale fisheries across the country.</p>
    </div>

    <div class="card">
        <h2>About Us & Legacy Tracking</h2>
        <p>The NATIONAL CONSORTIUM FOR SMALL SCALE FISHERIES RESEARCH AND DEVELOPMENT OR TOO-BIG-TO-IGNORE (TBTI) PHILIPPINES is a research network and knowledge mobilization partnership that focuses on addressing issues and concerns affecting the viability and sustainability of small-scale fisheries (SSF) in the Philippines. The symposium organizers highly encourage and welcome submissions focusing on the diverse aspects of small-scale fisheries. Research, case studies, and field experiences addressing governance, environmental resilience, socioeconomic dynamics, cultural heritage, and technological innovations within small-scale fisheries are eligible for presentation. The symposium serves as an inclusive platform for researchers, academics, practitioners, civil society organizations, and students to share insights, engage in meaningful dialogue, and contribute to the sustainable development of small-scale fisheries in the Philippines and the broader region.</p>
        
        <div class="legacy-timeline">
            <div class="timeline-card">
                <div class="timeline-aside">
                    <div class="timeline-tag">PSSFNS 1</div>
                    <div class="timeline-date">Oct 16–18, 2024</div>
                </div>
                <div class="timeline-details">
                    <strong>Host Institution:</strong> University of the Philippines Visayas (Miagao, Iloilo)<br>
                    Launched the inaugural national symposium, establishing a vital foundation for marine and fisheries research collaboration from a leading institutional hub.
                </div>
            </div>

            <div class="timeline-card">
                <div class="timeline-aside">
                    <div class="timeline-tag">PSSFNS 2</div>
                    <div class="timeline-date">Oct 21–23, 2025</div>
                </div>
                <div class="timeline-details">
                    <strong>Host Institution:</strong> Mindanao State University (Marawi City, Mindanao)<br>
                    Expanded the symposium’s reach and engagement directly to stakeholders and aquatic communities in the southern Philippines.
                </div>
            </div>

            <div class="timeline-card current-host">
                <div class="timeline-logo-box">
                    <img src="https://via.placeholder.com/120?text=BatStateU+Logo" alt="Batangas State University Official Logo">
                </div>
                <div class="timeline-aside">
                    <div class="timeline-tag" style="color: var(--secondary);">PSSFNS 3</div>
                    <div class="timeline-date">Oct 21–23, 2026</div>
                </div>
                <div class="timeline-details">
                    <strong>Host Institution:</strong> Batangas State University (Batangas City, Luzon)<br>
                    Continuing the collaborative tradition, this iteration centers on <em>“From Action to Replication: Scaling Up and Deepening the Impact of Small-Scale Fisheries,”</em> further fostering nationwide dialogue and academic excellence from the Luzon region.
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Host Organizer</h2>
        <div class="organizer-section">
            <img class="organizer-logo" src="https://via.placeholder.com/120?text=BatStateU+Logo" alt="Batangas State University Official Logo Badge">
            <div class="organizer-text">
                <p>Established as the Philippines’ National Engineering University by virtue of Republic Act No. 11694, Batangas State University (BatStateU) is a Level IV state institution with a 120-year legacy that positions it as a premier provider of advanced learning and a catalyst for national economic growth. As the country's largest engineering university in terms of enrollment and program offerings, it serves over 64,000 students across 12 campuses, boasting extensive international validations that include ABET-accredited programs, a three-star Quacquarelli Symonds rating, and impressive 2025 global milestones such as ranking 111th in the World University Rankings for Innovation (WURI) and 239th in the UI GreenMetric World University Rankings. Officially designated as a Special Economic Zone for its pioneering Knowledge, Innovation, and Science Technology (KIST) Park, the university functions as a vital public service hub hosting multiple national Centers of Excellence and Development designated by CHED. Through its dedicated Center for Sustainable Development and robust policy frameworks aligned with the 2030 Global Goals, BatStateU continuously expands its 46 graduate and undergraduate engineering degree programs to cultivate a highly trained corps of global leaders capable of creating leading-edge solutions to the nation’s infrastructure, energy, and environmental challenges.</p>
            </div>
        </div>
    </div>
</div>

<div id="program" class="page">
<h1>Symposium Program</h1>
<div class="card">
<table>
<tr><th>Day / Date</th><th>Activity</th></tr>
<tr><td>October 21, 2026</td><td>Opening Ceremony, Welcome Dinner & Plenary Sessions</td></tr>
<tr><td>October 22, 2026</td><td>Parallel Scientific, Student Presentations & Arts Sessions</td></tr>
<tr><td>October 23, 2026</td><td>Awards Presentation & Closing Ceremony</td></tr>
</table>
</div>
</div>

<div id="themes" class="page">
<h1>Symposium Themes</h1>
<div class="card">
<p>Abstract submissions are grouped into the following specialized symposium session themes:</p>
<ul>
  <li><strong>Theme 1:</strong> Biology, Ecology, and Marine Small-Scale Fisheries</li>
  <li><strong>Theme 2:</strong> Small-Scale Fisheries Management and Governance</li>
  <li><strong>Theme 3:</strong> Economics of Small-Scale Fisheries</li>
  <li><strong>Theme 4:</strong> Socio-cultural Aspects of Small-Scale Fisheries</li>
  <li><strong>Theme 5:</strong> Climate Change and Resilience of Small-Scale Fisheries</li>
  <li><strong>Theme 6:</strong> Gender in Small-Scale Fisheries</li>
  <li><strong>Theme 7:</strong> Technology and Innovation in Small-Scale Fisheries</li>
  <li><strong>Theme 8:</strong> Arts and Small-Scale Fisheries</li>
</ul>
</div>
</div>

<div id="abstract" class="page">
<h1>Abstract Submission</h1>
<div class="card">
<h3>Call for Abstracts (Scientific Oral & Poster Sessions / Competitions)</h3>
<p>We are pleased to invite submissions for individual abstracts formatted using the official sample guidelines. Submission must include: Title (max 25 words, Arial 14pt bold, scientific names italicized), list of co-authors, bolded presenting author, email, and an abstract text of 300 words or fewer (Arial 12pt, 1.15 line spacing) alongside 3 to 5 keywords.</p>
<a href="PSSFNS 3 - GUIDELINES.docx" class="btn">Download Abstract Guidelines Docx</a>
</div>
</div>

<div id="competition" class="page">
<h1>Student Competitions</h1>
<p>Review the comprehensive guidelines, evaluation metrics, and timeline milestones for the four concurrent student competition categories below.</p>

<div class="comp-grid">
    
    <div class="card">
        <div class="comp-header">
            <span class="comp-badge">Graduate & Undergraduate Teams</span>
            <h2>1. Fishing for Solutions Competition</h2>
        </div>
        <p><strong>Eligibility:</strong> Open to graduate and undergraduate students (18 years and above). Teams must consist of 3 to 5 members and have exactly 1 faculty mentor.</p>
        <p><strong>Abstract Requirements:</strong> Submit an abstract of the proposed technical solution addressing any gap or problem related to the theme of the Symposium. Deadline is <strong>July 31, 2026 at 23:59 PST (UTC+8)</strong> through the official website submission portal.</p>
        <p><strong>Video Submission:</strong> Authors of accepted abstracts must submit a technical presentation video and script detailing structural mechanisms. Content submitted grants the organizers permission to publish layouts across ecosystem platforms.</p>
        
        <h4>Judging Evaluation Criteria:</h4>
        <table>
            <tr><th>Criteria Component</th><th>Weight Percentage</th></tr>
            <tr><td>Clarity of the problem presented</td><td>25%</td></tr>
            <tr><td>Clarity and soundness of the proposed solution process</td><td>25%</td></tr>
            <tr><td>Workability and feasibility of the proposed solution</td><td>25%</td></tr>
            <tr><td>Potential impact of the proposed solution when implemented</td><td>25%</td></tr>
            <tr><td><strong>Total Weight</strong></td><td><strong>100%</strong></td></tr>
        </table>

        <div class="prize-highlight">
            <strong>Prizes & Operational Rules:</strong> Winners announced during the Closing Ceremony on October 23, 2026.
            <ul>
                <li><strong>First Place:</strong> Php 10,000 | <strong>Second Place:</strong> Php 8,000 | <strong>Third Place:</strong> Php 5,000</li>
                <li>Certificates of Recognition awarded to major winners and their faculty mentors.</li>
                <li><em>A minimum of six (6) qualified submissions must be received for the competition to proceed.</em></li>
            </ul>
        </div>
        <a href="PSSFNS3_Fishing_For_Solutions_Guidelines.docx" class="btn-doc">📄 View Full Guidelines & Rules (Docx)</a>
    </div>

    <div class="card">
        <div class="comp-header">
            <span class="comp-badge">Individual or Team (Max 3)</span>
            <h2>2. Student Vlog Competition (Documenting Small Stories with Big Impact)</h2>
        </div>
        <p><strong>Theme:</strong> Small-Scale Fisheries as a Way of Life</p>
        <p><strong>Sub-Themes (Select One):</strong>
            <br>• <strong>Bright Spots:</strong> Highlighting the structural contributions, strengths, and inspiring practices in small-scale fisheries.
            <br>• <strong>Hope Spots:</strong> Highlighting challenges, direct needs, aspirations, and possibilities for system improvement.
        </p>
        <p><strong>Eligibility:</strong> Open to individual students or teams up to a maximum of 3 members. Abstract declaration of vlog genre (e.g., travel, documentary, cooking, feature, or lifestyle) must be submitted on or before <strong>August 15, 2026 at 23:59 PST (UTC+8)</strong>.</p>
        
        <h4>Two-Stage Evaluation breakdown:</h4>
        <p><strong>Stage 1: Abstract (30% of total)</strong> — Thematic Clarity (40%), Creativity (40%), Feasibility (20%)</p>
        <p><strong>Stage 2: Vlog Entry (70% of total)</strong> — Cinematic & Visual Quality (30%), Audio & Sound Quality (30%), Storytelling & Content (40%)</p>

        <div class="prize-highlight">
            <strong>Prizes & Showcase Details:</strong> Separate sets of cash awards will be rendered for BOTH categories (Bright and Hope Spots):
            <ul>
                <li><strong>First Place:</strong> Php 10,000 | <strong>Second Place:</strong> Php 8,000 | <strong>Third Place:</strong> Php 5,000</li>
                <li>All qualified vlog entries will be hosted on a looped public display monitor setup directly within the main physical symposium venue lobby.</li>
                <li><em>A minimum of six (6) qualified submissions must be received for the competition to proceed.</em></li>
            </ul>
        </div>
        <a href="PSSFNS3_Student_Vlog_Guidelines.docx" class="btn-doc">📄 View Full Guidelines & Rules (Docx)</a>
    </div>

    <div class="card">
        <div class="comp-header">
            <span class="comp-badge">Individual Brackets (Undergrad / Graduate)</span>
            <h2>3. Student Oral Speed Presentation Competition</h2>
        </div>
        <p><strong>Process and Milestones:</strong> Open to both graduate and undergraduate individual student tracks. The evaluation committee issues official validation qualifiers on <strong>August 15, 2026</strong>. Final conference event registration must be settled before <strong>September 15, 2026</strong>.</p>
        <p><strong>Submission Parameters:</strong> Deliver a five-minute prerecorded video showing both presenter and slides simultaneously, alongside the presentation text script, on or before <strong>October 4, 2026</strong>. Presenters may use 1 static slide up to a maximum of 5 slides (numbered "Page x of y" in the lower right corner).</p>
        
        <h4>Judging Evaluation Breakdown:</h4>
        <table>
            <tr><th>Criteria Component</th><th>Weight Percentage</th></tr>
            <tr><td>Originality and creativity</td><td>25%</td></tr>
            <tr><td>Organization and logical presentation of ideas</td><td>25%</td></tr>
            <tr><td>Oral presentation and delivery</td><td>25%</td></tr>
            <tr><td>Neatness and clarity of presentation slides</td><td>10%</td></tr>
            <tr><td>Q&A Session: Technical capacity to answer real-time panel questions</td><td>15%</td></tr>
            <tr><td><strong>Total Weight</strong></td><td><strong>100%</strong></td></tr>
        </table>

        <div class="prize-highlight">
            <strong>Prizes & Track Brackets:</strong> Cash distributions are handed out identically across individual undergraduate and graduate category lines:
            <ul>
                <li><strong>Best Student Oral Presenter (Undergraduate Track):</strong> 3 Winners @ Php 7,000 each</li>
                <li><strong>Best Student Oral Presenter (Graduate Track):</strong> 3 Winners @ Php 7,000 each</li>
                <li><em>A minimum of six (6) qualified submissions must be received per category bracket for the track to run.</em></li>
            </ul>
        </div>
        <a href="9. PSSFNS 3 - Student Oral Speed Presentation Competition Guidelines (Graduate & Undergraduate).docx" class="btn-doc">📄 View Full Guidelines & Rules (Docx)</a>
    </div>

    <div class="card">
        <div class="comp-header">
            <span class="comp-badge">Individual Brackets (Undergrad / Graduate)</span>
            <h2>4. Student Poster Presentation Competition</h2>
        </div>
        <p><strong>Timelines:</strong> Track entry parameters align with submission screening protocols. Status alerts go live on <strong>August 15, 2026</strong>. Validated competitors must finalize institutional registration by <strong>September 15, 2026</strong>, and upload their 1-page digital poster graphic on or before <strong>October 4, 2026</strong>.</p>
        <p><strong>Mandatory Poster Outline Content:</strong> Title, Author names & Institutional affiliations, Introduction (with background/objectives), Materials and Methods, Results (with tables, graphs, or charts), Conclusions and Recommendations, References, and Acknowledgments.</p>
        
        <h4>Judging Evaluation Breakdown:</h4>
        <table>
            <tr><th>Criteria Component</th><th>Weight Percentage</th></tr>
            <tr><td>Scholarly content</td><td>35%</td></tr>
            <tr><td>Quality of poster appearance and presentation</td><td>35%</td></tr>
            <tr><td>Overall impression and significance of the research</td><td>15%</td></tr>
            <tr><td>Q&A Session: Ability to answer direct review board questions</td><td>15%</td></tr>
            <tr><td><strong>Total Weight</strong></td><td><strong>100%</strong></td></tr>
        </table>

        <div class="prize-highlight">
            <strong>Prizes & Category Distributions:</strong> Managed across individual graduate and undergraduate brackets:
            <ul>
                <li><strong>Best Student Poster Presenter (Undergraduate Category):</strong> 3 Winners @ Php 7,000 each</li>
                <li><strong>Best Student Poster Presenter (Graduate Category):</strong> 3 Winners @ Php 7,000 each</li>
                <li><em>A minimum of six (6) qualified submissions must be received per category bracket for the track to run.</em></li>
            </ul>
        </div>
        <a href="PSSFNS3_Student_Poster_Guidelines.docx" class="btn-doc">📄 View Full Guidelines & Rules (Docx)</a>
    </div>

</div>
</div>

<div id="registration" class="page">
<h1>Registration Details</h1>
<div class="card">
<p>All attendees, presenters, and competition participants should officially register for the PSSFNS 3. Registration includes admission, certificates, e-book of abstracts, proceedings, symposium souvenirs, conference meals, and the welcome dinner.</p>
<table>
  <tr><th>Category</th><th>TBTI Member Rate</th><th>Non-TBTI Member Rate</th></tr>
  <tr><td><strong>Student</strong></td><td>Php 2,500</td><td>Php 3,500</td></tr>
  <tr><td><strong>Non-Student</strong></td><td>Php 6,000</td><td>Php 7,000</td></tr>
</table>
<p><strong>Presenter Registration Deadline:</strong> September 15, 2026</p>
<button class="btn">Proceed to Registration Form</button>
</div>
</div>

<div id="committee" class="page">
<h1>Organizing Committee</h1>
<div class="card">
<p><strong>Host Institution:</strong> Batangas State University (Batangas City, Luzon)</p>
<p><strong>Collaborating Leadership:</strong> TBTI Philippines National Consortium Coordinating Executive Council</p>
</div>
</div>

<div id="partners" class="page">
<h1>Our Partners</h1>
<div class="card">
<p>Organized in alliance with 48 rotating state colleges and universities (SUCs) across the Philippines nationwide focusing on Marine Resources and Fisheries Development.</p>
</div>
</div>

<div id="hotels" class="page">
<h1>Hotels & Accommodation</h1>
<div class="card">
<p>Click the tracking action button below to pin your device's live coordinates. A direct connection vector route line will link your position to Batangas State University.</p>
<button class="btn" onclick="locateMe()">Draw Route to Venue</button>
<div id="map"></div>
</div>
</div>

<div id="proceeding" class="page">
<h1>Symposium Proceedings</h1>
<div class="card">
<h3>Official Electronic Documentation</h3>
<p>Registered participants gain open-access downloading codes for the digital e-copy of the Book of Abstracts and the complete Symposium Proceedings compiled post-event.</p>
<button class="btn">Download Proceedings Manual</button>
</div>
</div>

<footer>
<p>&copy; 2026 TBTI Philippines National Consortium - PSSFNS 3. All Rights Reserved.</p>
<p>Fostering Action to Replication in Small-Scale Fisheries Research</p>
</footer>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
// Page routing system
function showPage(pageId){
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => page.classList.remove('active'));
    document.getElementById(pageId).classList.add('active');
    window.scrollTo(0,0);
    
    if(pageId == 'hotels'){ 
        setTimeout(() => { 
            map.invalidateSize(); 
        }, 200); 
    }
}

// Mobile responsive navigation toggle
function toggleMenu(){
    const navLinks = document.getElementById('nav-links');
    navLinks.classList.toggle('active');
}

// Countdown Timer setup for Symposium Launch (October 21, 2026)
const registrationDeadline = new Date("2026-10-21T08:00:00").getTime();
const countdownEl = document.getElementById('countdown');
setInterval(() => {
    const now = new Date().getTime();
    const distance = registrationDeadline - now;
    if(distance < 0){ countdownEl.innerHTML = "Symposium Active / Closed"; return; }
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    countdownEl.innerHTML = `<span>${days}d</span> <span>${hours}h</span> <span>${minutes}m</span> <span>${seconds}s</span>`;
}, 1000);

// Leaflet Map Configuration - Centered on Batangas State University Main Campus Area
let map = L.map('map').setView([13.7542, 121.0520], 14);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Main Symposium Venue Pin - interactive:false completely strips native click events
const venueLatLng = [13.7542, 121.0520];
const bsuVenueMarker = L.marker(venueLatLng, { interactive: false }).addTo(map);

// Local Accommodations Array
const accommodations = [
    { name: "Days Hotel by Wyndham Batangas", coords: [13.7648, 121.0601] },
    { name: "Luks Lofts Hotel", coords: [13.7431, 121.0495] },
    { name: "Batangas City City Center Pension", coords: [13.7562, 121.0568] }
];

accommodations.forEach(place => { 
    L.marker(place.coords, { interactive: false }).addTo(map); 
});

// Polyline array vector wrapper variables
let activeRouteLine = null;
let userMarker = null;

// Draw route lines with clean vector paths without any markers intercepting actions
function locateMe(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(pos => {
            const userLatLng = [pos.coords.latitude, pos.coords.longitude];
            
            // Clean older layers
            if(activeRouteLine) { map.removeLayer(activeRouteLine); }
            if(userMarker) { map.removeLayer(userMarker); }
            
            // Generate non-interactive user point marker
            userMarker = L.marker(userLatLng, { interactive: false }).addTo(map);
            
            // Draw pure route line geometry connection path
            const routeCoordinates = [userLatLng, venueLatLng];
            activeRouteLine = L.polyline(routeCoordinates, {
                color: '#005b96',
                weight: 6,
                opacity: 0.8,
                dashArray: '10, 10',
                lineJoin: 'round'
            }).addTo(map);
            
            // Auto fit window securely
            const bounds = L.latLngBounds([userLatLng, venueLatLng]);
            map.fitBounds(bounds, { padding: [50, 50] });
            map.invalidateSize();
            
        }, () => { 
            alert("Error: Unable to fetch your current coordinates. Please verify your browser location access permissions."); 
        });
    } else { 
        alert("Error: Your current browser build does not support tracking mechanics."); 
    }
}
</script>
</body>
</html>