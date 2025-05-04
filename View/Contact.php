
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="contact.css" rel="stylesheet">
    <link href="contact.css" rel="stylesheet">
</head>
<body>

<?php include("Navbar.php"); ?>


    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h1 class="display-3 fw-bold mb-4">Contactez-nous</h1>
                    <p class="lead">
                        
                        <span class="highlight-text">Nous sommes là pour répondre à toutes vos questions.</span>
                    </p>
                    
                    
                </div>
            </div>
        </div>
    </section>

  <!-- Formulaire -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5 border-form">
                        <h2 class="text-center mb-4">Envoyez-nous un message</h2>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" required>
                                </div>
                                <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" required>
                                </div>
                                <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                                    <label for="email" class="form-label">Adresse e-mail</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-12" data-aos="fade-up" data-aos-delay="400">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12 text-center mt-4" data-aos="fade-up" data-aos-delay="500">
                                    <button type="submit" class="btn btn-stagik px-4 py-2">Envoyer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include("Footer.php"); ?>
     
</body>
</html>