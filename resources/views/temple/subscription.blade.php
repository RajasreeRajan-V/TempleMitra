<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscription Required · TempleMitra</title>
  
  <!-- Google Fonts matching the login page -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
  
  <style>
    /* ----- reset & base ----- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #faf8f5; /* warm off-white base matching the login page */
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      padding: 2rem;
      line-height: 1.5;
      color: #1a2639;
    }

    /* ----- container & card ----- */
    .container {
      width: 100%;
      max-width: 520px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      background: #ffffff;
      border-radius: 2rem;
      box-shadow: 
        0 30px 60px -20px rgba(0, 0, 0, 0.25),
        0 15px 30px -12px rgba(0, 20, 30, 0.1),
        0 0 0 1px rgba(0, 0, 0, 0.02);
      padding: 3.5rem 2.5rem;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    /* Decorative gold ring at the top */
    .card::before {
      content: '';
      position: absolute;
      top: -60px;
      left: 50%;
      transform: translateX(-50%);
      width: 140px;
      height: 140px;
      border-radius: 50%;
      border: 1px solid rgba(219, 181, 106, 0.3);
      pointer-events: none;
    }

    .card:hover {
      box-shadow: 
        0 35px 70px -20px rgba(0, 0, 0, 0.3),
        0 18px 35px -12px rgba(0, 20, 30, 0.15),
        0 0 0 1px rgba(0, 0, 0, 0.02);
      transform: translateY(-3px);
    }

    /* ----- icon decoration ----- */
    .icon-circle {
      width: 72px;
      height: 72px;
      background: linear-gradient(145deg, #fef7e8, #fdf0d5);
      border: 1px solid #f0e0c0;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2rem;
      box-shadow: 0 8px 16px -6px rgba(219, 181, 106, 0.3);
      position: relative;
      z-index: 1;
    }

    /* ----- headings & text ----- */
    .eyebrow {
      font-size: 0.8rem;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: #dbb56a;
      font-weight: 500;
      margin-bottom: 0.75rem;
      position: relative;
      z-index: 1;
    }

    h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 500;
      letter-spacing: -0.01em;
      color: #2c1e1a;
      margin-bottom: 1.5rem;
      line-height: 1.2;
      position: relative;
      z-index: 1;
    }

    /* Subtle gold underline accent */
    h2::after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, #dbb56a, #b8923c);
      border-radius: 4px;
      margin: 1rem auto 0;
      opacity: 0.8;
    }

    p {
      font-size: 1.05rem;
      color: #4a3a2e;
      margin-bottom: 0.75rem;
      font-weight: 400;
      line-height: 1.7;
      position: relative;
      z-index: 1;
    }

    p + p {
      color: #6b5a4a;
      font-size: 1rem;
      margin-bottom: 2.5rem;
    }

    /* ----- button styling (matching the login page maroon button) ----- */
    .btn {
      display: inline-block;
      background: linear-gradient(145deg, #6b1e2a, #3d0a12);
      color: #f5ede4;
      font-weight: 500;
      font-size: 1.05rem;
      padding: 1rem 2.5rem;
      border-radius: 14px;
      text-decoration: none;
      letter-spacing: 0.02em;
      box-shadow: 0 10px 20px -10px rgba(107, 30, 42, 0.4);
      transition: all 0.25s ease;
      border: 1px solid rgba(255, 215, 150, 0.1);
      cursor: pointer;
      min-width: 220px;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .btn:hover {
      background: linear-gradient(145deg, #7d2532, #4a0e1a);
      transform: translateY(-2px);
      box-shadow: 0 14px 24px -10px rgba(107, 30, 42, 0.5);
      color: #ffffff;
    }

    .btn:active {
      transform: translateY(0);
      box-shadow: 0 6px 12px -8px rgba(107, 30, 42, 0.5);
    }

    .btn:focus-visible {
      outline: 3px solid rgba(219, 181, 106, 0.4);
      outline-offset: 3px;
    }

    /* ----- responsive adjustments ----- */
    @media (max-width: 480px) {
      body {
        padding: 1rem;
      }

      .card {
        padding: 2.5rem 1.5rem;
        border-radius: 1.75rem;
      }

      h2 {
        font-size: 1.8rem;
      }

      p {
        font-size: 0.95rem;
      }

      .btn {
        padding: 0.9rem 1.5rem;
        font-size: 1rem;
        width: 100%;
        min-width: unset;
      }

      .icon-circle {
        width: 60px;
        height: 60px;
        font-size: 1.6rem;
      }
    }

    /* ----- reduced motion ----- */
    @media (prefers-reduced-motion: reduce) {
      .card,
      .btn {
        transition: none;
      }
      .card:hover,
      .btn:hover {
        transform: none;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <!-- Icon badge -->
      <div class="icon-circle">🛕</div>
      
      <!-- Content -->
      <div class="eyebrow">TempleMitra</div>
      <h2>Subscription Required</h2>
      
      <p>
        Your one-month free registration period has been completed.
      </p>
      <p>
        Please subscribe to continue using TempleMitra and managing your temple operations seamlessly.
      </p>
      
      <!-- Button -->
      <a href="#" class="btn">
        Subscribe Now
      </a>
    </div>
  </div>
</body>
</html>