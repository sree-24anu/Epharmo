<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Footer Styles */
footer {
  background-color: #186970;
  color: #fff;
  padding: 50px 0;
}

.footer-container {
  display: flex;
  justify-content: space-around;
  align-items: flex-start;
}

.footer-info,
.footer-links,
.footer-contact {
  flex: 1;
  margin: 0 20px;
}
.footer-links{
    display: flex;
    justify-content: space-evenly;
}
.footer-info h3,
.footer-links h3,
.footer-contact h3 {
  font-size: 20px;
}

.footer-info p,
.footer-links ul,
.footer-contact p {
  font-size: 14px;
}

.footer-links ul {
  list-style-type: none;
  padding: 0;
}

.footer-links ul li {
  margin-bottom: 10px;
}

.footer-links ul li a {
  color: #fff;
  text-decoration: none;
}

.footer-links ul li a:hover {
  text-decoration: underline;
}

.footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  display: block;
}

.footer-bottom p {
  font-size: 14px;
}

.social-icons a {
  color: #fff;
  text-decoration: none;
  margin-left: 10px;
}

.social-icons a:hover {
  color: #ccc;
}

    </style>
</head>
<body>
<footer>
  <div class="footer-container">
    <div class="footer-info">
      <h3>About Us</h3>
      <p>We at Epharmosys provide a wide variety of medicine divided based on allopathy and ayurveda .</p>
    </div>
    <div class="footer-links">
      <div class="main">
        <h3>Quick Links</h3>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">Reviews</a></li>
        </ul>
      </div>
      <div class="sub">
        <h3>Featured categories</h3>
        <ul>
            <li><a href="#">Allopathy</a></li>
            <li><a href="#">Ayurveda</a></li>
            <li><a href="#">Reviews</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-contact">
      <h3>Contact Us</h3>
      <p>123 Street Epharmosys, Manglore, India</p>
      <p>Email: epharmosys@example.com</p>
      <p>Phone: +91 999 999 9999</p>
    </div>
  </div>
  <div class="footer-bottom text-center">
    <p >&copy; 2024 Epharmosys . All rights reserved.</p>
    <!-- <div class="social-icons">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
    </div> -->
  </div>
  <br><br>
</footer>

</body>
</html>