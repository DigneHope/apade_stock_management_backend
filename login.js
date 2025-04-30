const express = require("express"); 
const router = express.Router();

// Hardcoded admin credentials
const ADMIN_EMAIL = "admin@example.com";
const ADMIN_PASSWORD = "admin123"; // Don't use this in production without hashing!

// POST request to login
router.post("/login", (req, res) => {
  const { email, password } = req.body;

  // Check if the credentials match
  if (email === ADMIN_EMAIL && password === ADMIN_PASSWORD) {
    res.json({ success: true });
  } else {
    res.json({ success: false });
  }
});

module.exports = router;
