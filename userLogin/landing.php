<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'login') {
            header("Location: login.php");
            exit();
        } elseif ($action == 'getStarted' || $action == 'getStartedMain') {
            header("Location: register.php"); 
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Thyroid Health and Wellness Center</title>
    <meta property="og:title" content="Medica template" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <meta property="twitter:card" content="summary_large_image" />

    <style data-tag="reset-style-sheet">
      html {  line-height: 1.15;}body {  margin: 0;}* {  box-sizing: border-box;  border-width: 0;  border-style: solid;  -webkit-font-smoothing: antialiased;}p,li,ul,pre,div,h1,h2,h3,h4,h5,h6,figure,blockquote,figcaption {  margin: 0;  padding: 0;}button {  background-color: transparent;}button,input,optgroup,select,textarea {  font-family: inherit;  font-size: 100%;  line-height: 1.15;  margin: 0;}button,select {  text-transform: none;}button,[type="button"],[type="reset"],[type="submit"] {  -webkit-appearance: button;  color: inherit;}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner {  border-style: none;  padding: 0;}button:-moz-focus,[type="button"]:-moz-focus,[type="reset"]:-moz-focus,[type="submit"]:-moz-focus {  outline: 1px dotted ButtonText;}a {  color: inherit;  text-decoration: inherit;}input {  padding: 2px 4px;}img {  display: block;}details {  display: block;  margin: 0;  padding: 0;}summary::-webkit-details-marker {  display: none;}[data-thq="accordion"] [data-thq="accordion-content"] {  max-height: 0;  overflow: hidden;  transition: max-height 0.3s ease-in-out;  padding: 0;}[data-thq="accordion"] details[data-thq="accordion-trigger"][open] + [data-thq="accordion-content"] {  max-height: 300vh;}details[data-thq="accordion-trigger"][open] summary [data-thq="accordion-icon"] {  transform: rotate(180deg);}html { scroll-behavior: smooth  }
    </style>
    <style data-tag="default-style-sheet">
      html {
        font-family: Poppins;
        font-size: 16px;
      }

      body {
        font-weight: 400;
        font-style:normal;
        text-decoration: none;
        text-transform: none;
        letter-spacing: normal;
        line-height: 1.15;
        color: var(--dl-color-gray-black);
        background: var(--dl-color-gray-white);

        fill: var(--dl-color-gray-black);
      }
    </style>
    <link
      rel="stylesheet"
      href="https://unpkg.com/animate.css@4.1.1/animate.css"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/@teleporthq/teleport-custom-scripts/dist/style.css"
    />
    <style>
      @keyframes fade-in-left {
        0% {
          opacity: 0;
          transform: translateX(-20px);
        }
        100% {
          opacity: 1;
          transform: translateX(0);
        }
      }
    </style>
  </head>
  <body>
    <link rel="stylesheet" href="../assets/css/front1.css" />
    <div>
      <link href="../assets/css/front.css" rel="stylesheet" />

      <div class="home-container1">
        <div data-modal="practices" class="home-modal1">
          <div class="home-practices1">
            <div class="home-heading10">
              <span class="home-header10">Our practices</span>
              <svg
                viewBox="0 0 1024 1024"
                data-close="practices"
                class="home-close"
              >
                <path
                  d="M225.835 286.165l225.835 225.835-225.835 225.835c-16.683 16.683-16.683 43.691 0 60.331s43.691 16.683 60.331 0l225.835-225.835 225.835 225.835c16.683 16.683 43.691 16.683 60.331 0s16.683-43.691 0-60.331l-225.835-225.835 225.835-225.835c16.683-16.683 16.683-43.691 0-60.331s-43.691-16.683-60.331 0l-225.835 225.835-225.835-225.835c-16.683-16.683-43.691-16.683-60.331 0s-16.683 43.691 0 60.331z"
                ></path>
              </svg>
            </div>
            <div class="home-grid1">
              <div class="home-section1">
                <div class="home-heading11">
                  <span class="home-header11">Cardiology</span>
                  <span class="home-caption1">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt.
                  </span>
                </div>
                <div class="read-more">
                  <span class="home-text10">Read more</span>
                  <img
                    alt="image"
                    src="public/Icons/arrow-2.svg"
                    class="home-image10"
                  />
                </div>
              </div>
              <div class="home-section2">
                <div class="home-heading12">
                  <span class="home-header12">Orthopedics</span>
                  <span class="home-caption2">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt.
                  </span>
                </div>
                <div class="read-more">
                  <span class="home-text11">Read more</span>
                  <img
                    alt="image"
                    src="public/Icons/arrow-2.svg"
                    class="home-image11"
                  />
                </div>
              </div>
              <div class="home-section3">
                <div class="home-heading13">
                  <span class="home-header13">Goiter</span>
                  <span class="home-caption3">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt.
                  </span>
                </div>
                <div class="read-more">
                  <span class="home-text12">Read more</span>
                  <img
                    alt="image"
                    src="public/Icons/arrow-2.svg"
                    class="home-image12"
                  />
                </div>
              </div>
              <div class="home-section4">
                <div class="home-heading14">
                  <span class="home-header14">Diabetes</span>
                  <span class="home-caption4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt.
                  </span>
                </div>
                <div class="read-more">
                  <span class="home-text13">Read more</span>
                  <img
                    alt="image"
                    src="public/Icons/arrow-2.svg"
                    class="home-image13"
                  />
                </div>
              </div>
              <div class="home-section5">
                <div class="home-heading15">
                  <span class="home-header15">Obesity</span>
                  <span class="home-caption5">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt.
                  </span>
                </div>
                <div class="read-more">
                  <span class="home-text14">Read more</span>
                  <img
                    alt="image"
                    src="public/Icons/arrow-2.svg"
                    class="home-image14"
                  />
                </div>
              </div>
              <div class="home-section6">
                <div class="home-heading16">
                  <span class="home-header16">Bone</span>
                  <span class="home-caption6">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt.
                  </span>
                </div>
                <div class="read-more">
                  <span class="home-text15">Read more</span>
                  <img
                    alt="image"
                    src="public/Icons/arrow-2.svg"
                    class="home-image15"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <section class="home-hero">
          <header class="home-header17">
            <header data-thq="thq-navbar" class="home-navbar">
              <div class="home-left1">
                <img
                  alt="image"
                  src=" ../assets/image/logo.png"
                  class="brand-image img-circle elevation-3" style="opacity: .8" 
                />
                <nav class="home-links1">
                  <a href="#features" class="home-link10">
                    Thyroid Health and Wellness Center
                  </a>
                </nav>
              </div>
              <div data-thq="thq-navbar-btn-group" class="home-right1">
              <a href="../userLogin/login.php" class="home-book1 button button-main">
  <span class="home-text16">Login</span>
</a>

              </div>
              <div data-thq="thq-burger-menu" class="home-burger-menu">
                <svg viewBox="0 0 1024 1024" class="home-icon2">
                  <path
                    d="M128 554.667h768c23.552 0 42.667-19.115 42.667-42.667s-19.115-42.667-42.667-42.667h-768c-23.552 0-42.667 19.115-42.667 42.667s19.115 42.667 42.667 42.667zM128 298.667h768c23.552 0 42.667-19.115 42.667-42.667s-19.115-42.667-42.667-42.667h-768c-23.552 0-42.667 19.115-42.667 42.667s19.115 42.667 42.667 42.667zM128 810.667h768c23.552 0 42.667-19.115 42.667-42.667s-19.115-42.667-42.667-42.667h-768c-23.552 0-42.667 19.115-42.667 42.667s19.115 42.667 42.667 42.667z"
                  ></path>
                </svg>
              </div>
              <div data-thq="thq-mobile-menu" class="home-mobile-menu">
                <div
                  data-thq="thq-mobile-menu-nav"
                  data-role="Nav"
                  class="home-nav1"
                >
                  <div class="home-container2">
                    <img
                      alt="image"
                      src="public/Branding/logo-1500h.png"
                      class="home-image16"
                    />
                    <div data-thq="thq-close-menu" class="home-menu-close">
                      <svg viewBox="0 0 1024 1024" class="home-icon4">
                        <path
                          d="M810 274l-238 238 238 238-60 60-238-238-238 238-60-60 238-238-238-238 60-60 238 238 238-238z"
                        ></path>
                      </svg>
                    </div>
                  </div>
                  <nav
                    data-thq="thq-mobile-menu-nav-links"
                    data-role="Nav"
                    class="home-nav2"
                  >
                    <span class="home-text17">Features</span>
                    <span class="home-text18">How it works</span>
                    <span class="home-text19">Prices</span>
                    <span class="home-text20">Contact</span>
                    <button class="home-book2 button button-main">
                      <img
                        alt="image"
                        src="public/Icons/calendar.svg"
                        class="home-image17"
                      />
                      <span class="home-text21">Book an appointment</span>
                    </button>
                  </nav>
                </div>
              </div>
              <div data-thq="thq-navbar-btn-group" class="home-right2">
                <button class="home-book3 button button-main">
                  <span class="home-text22">Start Your Wellness Journey</span>
                </button>
              </div>
            </header>
          </header>
          <div class="home-main1">
            <div class="home-content1">
              <div class="home-heading17">
                <h1 class="home-header18">Optimize Your Thyroid Health</h1>
                <p class="home-caption7">
                The Thyroid Health and Wellness Center specializes in comprehensive care for thyroid and brain function, offering diagnostic tests, consultations, and treatment services. It addresses patient needs through dedicated care while aiming to improve operational efficiency and service delivery.
                </p>
              </div>
              <button class="button button-main home-book4">
                <span>Start Your Wellness Journey</span>
              </button>
            </div>
            <div class="home-image18">
              <img
                alt="image"
                src="public/doctor-image-1500w.png"
                class="home-image19"
              />
            </div>
          </div>
          <div id="features" class="home-features1">
            <div class="home-content2">
              <features-wrapper class="features-wrapper">
                <!--Features component-->
                <div class="features-section quick-links">
                  <div class="features-heading">
                    <h3 class="features-header">
                      <span>Assistant</span>
                    </h3>
                    <img
                      alt="image"
                      src="public/Icons/arrow.svg"
                      class="features-icon"
                    />
                  </div>
                  <p class="features-text">
                    <span>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </span>
                  </p>
                  <div class="features-divider"></div>
                </div>
              </features-wrapper>
              <features-wrapper-xna0 class="features-wrapper-xna0">
                <!--Features component-->
                <div class="features-section1 quick-links">
                  <div class="features-heading1">
                    <h3 class="features-header1">
                      <span>Clinic</span>
                    </h3>
                    <img
                      alt="image"
                      src="public/Icons/arrow.svg"
                      class="features-icon1"
                    />
                  </div>
                  <p class="features-text1">
                    <span>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </span>
                  </p>
                  <div class="features-divider1"></div>
                </div>
              </features-wrapper-xna0>
              <features-wrapper-6dby class="features-wrapper-6dby">
                <!--Features component-->
                <div class="features-section2 quick-links">
                  <div class="features-heading2">
                    <h3 class="features-header2">
                      <span>Clinic</span>
                    </h3>
                    <img
                      alt="image"
                      src="public/Icons/arrow.svg"
                      class="features-icon2"
                    />
                  </div>
                  <p class="features-text2">
                    <span>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </span>
                  </p>
                  <div class="features-divider2"></div>
                </div>
              </features-wrapper-6dby>
            </div>
          </div>
          <div class="home-background"></div>
        </section>
        <section class="home-practices2" id="home-practices2">
          
          <div class="home-content3">
            <div class="home-grid2">
              <a href="index.html">
                <div class="home-practice-wrapper1">
                  <practice-wrapper class="practice-wrapper">
                    <!--Practice component-->
                    <div class="practice-practice">
                      <div class="practice-heading">
                        <h3 class="practice-header"><span>Cardiology</span></h3>
                        <p class="practice-caption">
                          <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt.
                          </span>
                        </p>
                      </div>
                      <div class="read-more">
                        <span class="practice-text">Read more</span>
                        <img
                          alt="image"
                          src="public/Icons/arrow-2.svg"
                          class="practice-image"
                        />
                      </div>
                    </div>
                  </practice-wrapper>
                </div>
              </a>
              <a href="index.html">
                <div class="home-practice-wrapper2">
                  <practice-wrapper-h5gs class="practice-wrapper-h5gs">
                    <!--Practice component-->
                    <div class="practice-practice1">
                      <div class="practice-heading1">
                        <h3 class="practice-header1">
                          <span>Orthopedics</span>
                        </h3>
                        <p class="practice-caption1">
                          <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt.
                          </span>
                        </p>
                      </div>
                      <div class="read-more">
                        <span class="practice-text1">Read more</span>
                        <img
                          alt="image"
                          src="public/Icons/arrow-2.svg"
                          class="practice-image1"
                        />
                      </div>
                    </div>
                  </practice-wrapper-h5gs>
                </div>
              </a>
              <a href="../userLogin/landing.php">
                <div class="home-practice-wrapper3">
                  <practice-wrapper-a52i class="practice-wrapper-a52i">
                    <!--Practice component-->
                    <div class="practice-practice2">
                      <div class="practice-heading2">
                        <h3 class="practice-header2">
                          <span>Goiter</span>
                        </h3>
                        <p class="practice-caption2">
                          <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt.
                          </span>
                        </p>
                      </div>
                      <div class="read-more">
                        <span class="practice-text2">Read more</span>
                        <img
                          alt="image"
                          src="public/Icons/arrow-2.svg"
                          class="practice-image2"
                        />
                      </div>
                    </div>
                  </practice-wrapper-a52i>
                </div>
              </a>
              <a href="index.html">
                <div class="home-practice-wrapper4">
                  <practice-wrapper-6uts class="practice-wrapper-6uts">
                    <!--Practice component-->
                    <div class="practice-practice3">
                      <div class="practice-heading3">
                        <h3 class="practice-header3">
                          <span>Diabetes</span>
                        </h3>
                        <p class="practice-caption3">
                          <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt.
                          </span>
                        </p>
                      </div>
                      <div class="read-more">
                        <span class="practice-text3">Read more</span>
                        <img
                          alt="image"
                          src="public/Icons/arrow-2.svg"
                          class="practice-image3"
                        />
                      </div>
                    </div>
                  </practice-wrapper-6uts>
                </div>
              </a>
              <a href="index.html">
                <div class="home-practice-wrapper5">
                  <practice-wrapper-1l3x class="practice-wrapper-1l3x">
                    <!--Practice component-->
                    <div class="practice-practice4">
                      <div class="practice-heading4">
                        <h3 class="practice-header4"><span>Obesity</span></h3>
                        <p class="practice-caption4">
                          <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt.
                          </span>
                        </p>
                      </div>
                      <div class="read-more">
                        <span class="practice-text4">Read more</span>
                        <img
                          alt="image"
                          src="public/Icons/arrow-2.svg"
                          class="practice-image4"
                        />
                      </div>
                    </div>
                  </practice-wrapper-1l3x>
                </div>
              </a>
              <a href="index.html">
                <div class="home-practice-wrapper6">
                  <practice-wrapper-m5y0 class="practice-wrapper-m5y0">
                    <!--Practice component-->
                    <div class="practice-practice5">
                      <div class="practice-heading5">
                        <h3 class="practice-header5"><span>Bone</span></h3>
                        <p class="practice-caption5">
                          <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt.
                          </span>
                        </p>
                      </div>
                      <div class="read-more">
                        <span class="practice-text5">Read more</span>
                        <img
                          alt="image"
                          src="public/Icons/arrow-2.svg"
                          class="practice-image5"
                        />
                      </div>
                    </div>
                  </practice-wrapper-m5y0>
                </div>
              </a>
            </div>
            <button data-open="practices" class="button button-main">
              <span>All practices</span>
            </button>
          </div>
        </section>
        <section class="home-features2">
          <div class="home-section7">
            <div class="home-content4">
              <div class="home-header19">
                <h2 class="home-heading19">
                  Dedicated doctors with the core mission to help.
                </h2>
                <p class="home-capton1">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                  do eiusmod tempor incididunt.
                </p>
              </div>
              <div class="read-more">
                <span class="home-text27">See our doctors</span>
                <img
                  alt="image"
                  src="public/Icons/arrow-2.svg"
                  class="home-image20"
                />
              </div>
            </div>
            <img alt="image" src="public/xray-1500w.png" class="home-image21" />
          </div>
          <div class="home-section8">
            <div class="home-content5">
              <div class="home-header20">
                <h2 class="home-heading20">
                  Get access to specialty tests and breakthrough information.
                </h2>
                <p class="home-capton2">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                  do eiusmod tempor incididunt.
                </p>
              </div>
              <div class="read-more">
                <span class="home-text28">Find test</span>
                <img
                  alt="image"
                  src="public/Icons/arrow-2.svg"
                  class="home-image22"
                />
              </div>
            </div>
            <img alt="image" src="public/lab-1500w.png" class="home-image23" />
          </div>
          <div class="home-section9">
            <div class="home-content6">
              <div class="home-header21">
                <h2 class="home-heading21">
                  Find out how we can help you help you.
                </h2>
                <p class="home-capton3">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                  do eiusmod tempor incididunt.
                </p>
              </div>
              <button class="button button-main home-book5">
                <span>Book an appointment</span>
              </button>
            </div>
            <img
              alt="image"
              src="public/examination-1500w.png"
              class="home-image24"
            />
          </div>
          <button class="home-book6 button button-main">
            <span>Book a virtual appointment</span>
          </button>
        </section>
        <section class="home-meet">
          <div class="home-heading22">
            <h2 class="home-text31">Meet our doctors</h2>
            <p class="home-text32">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt.
            </p>
          </div>
          <div class="home-list1">
            <div class="home-controls">
              <img
                alt="image"
                src="public/Icons/circle-arrow.svg"
                data-doctors="previous"
                class="arrow"
              />
              <img
                alt="image"
                src="public/Icons/circle-arrow.svg"
                data-doctors="next"
                class="home-forward arrow"
              />
            </div>
            <div data-teleport="doctors" class="home-doctors1">
              <doctor-wrapper class="doctor-wrapper">
                <!--Doctor component-->
                <div class="doctor-doctor">
                  <img
                    alt="image"
                    src="public/Doctors/doctor-1-300w.png"
                    class="doctor-image"
                  />
                  <div class="doctor-heading">
                    <h2 class="doctor-text1"><span>Dr. Audrey Smith</span></h2>
                    <p class="doctor-text2">
                      <span>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt.
                      </span>
                    </p>
                  </div>
                </div>
              </doctor-wrapper>
              <doctor-wrapper-jcbi class="doctor-wrapper-jcbi">
                <!--Doctor component-->
                <div class="doctor-doctor1">
                  <img
                    alt="image"
                    src="public/Doctors/doctor-2-300w.png"
                    class="doctor-image1"
                  />
                  <div class="doctor-heading1">
                    <h2 class="doctor-text3"><span>Dr. Audrey Smith</span></h2>
                    <p class="doctor-text4">
                      <span>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt.
                      </span>
                    </p>
                  </div>
                </div>
              </doctor-wrapper-jcbi>
              <doctor-wrapper-fm66 class="doctor-wrapper-fm66">
                <!--Doctor component-->
                <div class="doctor-doctor2">
                  <img
                    alt="image"
                    src="public/Doctors/doctor-3-300w.png"
                    class="doctor-image2"
                  />
                  <div class="doctor-heading2">
                    <h2 class="doctor-text5"><span>Dr. Audrey Smith</span></h2>
                    <p class="doctor-text6">
                      <span>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt.
                      </span>
                    </p>
                  </div>
                </div>
              </doctor-wrapper-fm66>
              <doctor-wrapper-masl class="doctor-wrapper-masl">
                <!--Doctor component-->
                <div class="doctor-doctor3">
                  <img
                    alt="image"
                    src="public/Doctors/doctor-4-300w.png"
                    class="doctor-image3"
                  />
                  <div class="doctor-heading3">
                    <h2 class="doctor-text7"><span>Dr. Audrey Smith</span></h2>
                    <p class="doctor-text8">
                      <span>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt.
                      </span>
                    </p>
                  </div>
                </div>
              </doctor-wrapper-masl>
            </div>
          </div>
          <div class="home-search">
            <input
              type="text"
              placeholder="Search by name"
              class="home-textinput input book-input"
            />
            <button class="button button-main home-book7">
              <span>Search doctor</span>
            </button>
          </div>
        </section>
        <div class="home-download"><div class="home-main2"></div></div>
        <div class="home-footer">
          <div class="home-left2">
            <div class="home-brand">
              <img
                alt="image"
                src="../image/logo.png"
                class="home-image25"
              />
              <p class="home-text34">
             Prioritizing your health,
            Committed to your strength, 
            Your partner in thyroid care, 
            Wellness for a better life, we’re here
              </p>
            </div>
            <div class="home-socials">
              <div class="social">
                <img
                  alt="image"
                  src="public/Icons/insider.svg"
                  class="home-image26"
                />
              </div>
              <div class="social">
                <img
                  alt="image"
                  src="public/Icons/instagram.svg"
                  class="home-image27"
                />
              </div>
              <div class="social">
                <img
                  alt="image"
                  src="public/Icons/twitter.svg"
                  class="home-image28"
                />
              </div>
            </div>
            <div class="home-legal1">
              <span class="home-copyright1">
                © 2024 Thyroid Health and Wellness Center. All Rights Reserved.
              </span>
              <span class="legal-link">Privacy Policy</span>
              <span class="legal-link">Terms of Use</span>
            </div>
          </div>
          <div class="home-right3">
            <div class="home-list2">
              <span class="home-header22">Menu</span>
              <div class="home-links2">
                <span class="home-link11">Home</span>
                <span class="home-link12">About</span>
                <span class="home-link13">Services</span>
                <span class="home-link14">Blog</span>
                <span class="home-link15">Support</span>
              </div>
            </div>
            <div class="home-list3">
              <span class="home-header23">Resources</span>
              <div class="home-links3">
                <span class="home-link16">Test Results</span>
                <span class="home-link17">Patients</span>
                <span class="home-link18">Doctors</span>
                <span class="home-link19">Health</span>
              </div>
            </div>
            <div class="home-list4">
              <span class="home-header24">Contact</span>
              <div class="home-links4">
                <span class="home-link20">
                  24 Street Name, City FI 01234, RO
                </span>
                <a
                  href="mailto:contact@template.new?subject=Main"
                  class="home-link21"
                >
                  contact@template.new
                </a>
                <a href="tel:(004) 234 - 5678" class="home-link22">
                  (004) 234 - 5678
                </a>
              </div>
            </div>
          </div>
          <div class="home-legal2">
            <div class="home-row">
              <span class="legal-link">Privacy Policy</span>
              <span class="legal-link">Terms of Use</span>
            </div>
            <span class="home-copyright6">
              © 2022 finbest. All Rights Reserved.
            </span>
          </div>
        </div>
        <div>
          <div class="home-container4">
            <script>
              const modalOpen = document.querySelectorAll('[data-open]');
              const modalClose = document.querySelectorAll('[data-close]');

              modalOpen.forEach(button => {
                  button.addEventListener('click', event => {
                      const modal = document.querySelector(`[data-modal='${event.target.dataset.open}']`);
                      modal.style.display = 'flex';
                  });
              });

              modalClose.forEach(button => {
                  button.addEventListener('click', event => {
                      const modal = document.querySelector(`[data-modal='${event.target.dataset.close}']`);
                      modal.style.display = 'none';
                  });
              });
            </script>
          </div>
        </div>
        <div>
          <div class="home-container6">
            <script>
              const dataLetters = document.querySelectorAll('[data-letter]');
              let activeLetters = [];
              const maxResults = 6;

              dataLetters.forEach(letter => {
                letter.addEventListener('click', function() {
                  if (this.classList.contains('letter-active')) {
                    this.classList.remove('letter-active');
                    activeLetters = activeLetters.filter(a => a !== this.dataset.letter);
                  } else {
                    this.classList.add('letter-active');
                    activeLetters.push(this.dataset.letter);
                  }
                  if (activeLetters.length == 0) {
                    document.querySelector('[data-teleport=',results,']').style.display = 'none';
                    return;
                  }
                  showResults();
                });
              });

              const showResults = () => {
                fetch('https://raw.githubusercontent.com/Shivanshu-Gupta/web-scrapers/master/medical_ner/medicinenet-diseases.json')
                  .then(response => response.json())
                  .then(data => {
                    const filteredData = data.filter(item => {
                      const firstLetter = item.disease.charAt(0).toLowerCase();
                      if (activeLetters.includes(firstLetter)) {
                        return true;
                      }
                      return false;
                    });

                    document.querySelector('[data-teleport=',results,']').style.display = 'flex';
                    const resultsContainer = document.querySelector('[data-results=',letters,']');
                    resultsContainer.innerHTML = '';

                    let counter = 0;
                    const diseaseGroups = {};
                    const totalActiveLetters = activeLetters.length;

                    filteredData.forEach(disease => {
                      const firstLetter = disease.disease[0].toLowerCase();
                      if (diseaseGroups[firstLetter]) {
                        diseaseGroups[firstLetter].push(disease);
                      } else {
                        diseaseGroups[firstLetter] = [disease];
                      }
                    });

                    Object.keys(diseaseGroups).sort().forEach((firstLetter, index) => {
                      const diseasesForThisLetter = diseaseGroups[firstLetter];
                      const diseasesToShow = diseasesForThisLetter.slice(0, Math.ceil(maxResults / totalActiveLetters));

                      diseasesToShow.forEach(disease => {
                        const resultContainer = document.createElement('div');
                        resultContainer.classList.add('search-result');
                        resultContainer.classList.add('invisible');
                        resultContainer.style.animationDelay = `${counter * 0.25}s`;

                        const resultText = document.createElement('span');
                        resultText.classList.add('result-text');
                        resultText.textContent = disease.disease;

                        resultContainer.appendChild(resultText);
                        resultsContainer.appendChild(resultContainer);
                        counter++;

                        if (counter === maxResults) {
                          const moreContainer = document.createElement('div');
                          moreContainer.classList.add('search-result');
                          moreContainer.classList.add('more-results');

                          const moreText = document.createElement('span');
                          moreText.classList.add('result-text');
                          moreText.textContent = 'More';

                          moreContainer.appendChild(moreText);
                          resultsContainer.appendChild(moreContainer);
                          addedMoreContainer = true;
                          return;
                        }
                      });
                    });
                  });
              };
            </script>
          </div>
        </div>
        <div>
          <div class="home-container8">
            <script>
              function scroll(direction) {
                const doctorsDiv = document.querySelector('[data-teleport=',doctors,']');
                const scrollAmount = 300;
                if (direction === 'previous') {
                  doctorsDiv.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                  });
                } else if (direction === 'next') {
                  doctorsDiv.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                  });
                }
              }

              const buttons = document.querySelectorAll('[data-doctors]');
              buttons.forEach(button => {
                button.addEventListener('click', () => {
                  const direction = button.dataset.doctors;
                  scroll(direction);
                });
              });
            </script>
          </div>
        </div>
      </div>
    </div>
    <script
      defer=""
      src="https://unpkg.com/@teleporthq/teleport-custom-scripts"
    ></script>
  </body>
</html>
