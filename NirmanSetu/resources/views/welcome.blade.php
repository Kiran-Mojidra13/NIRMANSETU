<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to NirmanSetu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Hero Section -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="display-4">NirmanSetu</h1>
        <p class="lead">Connecting Construction Needs with Certified Experts.</p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg mt-3">Login</a>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Services</h2>
        <div class="row">
            <div class="col-md-4">
                <h4>Building Consultation</h4>
                <p>Expert advice from engineers and architects for your projects.</p>
            </div>
            <div class="col-md-4">
                <h4>Material Suppliers</h4>
                <p>Direct connect with verified suppliers for quality materials.</p>
            </div>
            <div class="col-md-4">
                <h4>Customer Support</h4>
                <p>Help & guidance for customers throughout the construction process.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">About NirmanSetu</h2>
        <p class="text-center">NirmanSetu is a platform that bridges the gap between customers, engineers, suppliers, and service providers in the construction domain. Our goal is to make the construction process smooth, transparent, and efficient.</p>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; {{ date('Y') }} NirmanSetu. All rights reserved.</p>
</footer>

</body>
</html>
