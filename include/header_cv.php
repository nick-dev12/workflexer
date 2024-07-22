



<link rel="stylesheet" href="../css/header_cv.css">


<section class="section2 ste" id="ste" >
    <img src="../image/croix.png" alt="" class="img111" id="img24">
        <div class="container">
            <div class="box1">
                <?php if ($users['statut'] == 'Disponible'): ?>
                    <button class="statut occ">
                        <?= $users['statut'] ?>
                    </button>
                <?php else: ?>
                    <?php if ($users['statut'] == 'Occuper'): ?>
                        <button class="statut disp">
                            <?= $users['statut'] ?>
                        </button>
                    <?php else: ?>
                        <button class="statut occ">Statut</button>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="div_statut">
                    <img class="imag" src="../image/croix.png" alt="">
                    <a class="disp" href="?occuper=<?= $users['id'] ?>">Occuper</a>
                    <a class=" occ" href="?disponible=<?= $users['id'] ?>">Disponible</a>
                </div>

                <script>
                    let statut = document.querySelector('.statut')
                    let div_statut = document.querySelector('.div_statut')
                    let imag = document.querySelector('.imag')
                    statut.addEventListener('click', () => {
                            div_statut.style.left = '0'
                    })
                    imag.addEventListener('click', () => {
                            div_statut.style.left = '-200%'
                    })

                    // Ajouter un gestionnaire au clic n'importe où sur la page
                    document.addEventListener('click', (e) => {
                        // Vérifier que le clic ne vient pas du bouton
                        if (e.target !== statut) {
                            // Masquer la div
                            div_statut.style.left = '-200%'
                        }
                    });
                </script>


                <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">
                <span></span>
                <h2>
                    <?php echo $users['nom']; ?>
                </h2>
            </div>

            <div class="box2">
                <h3>
                    <?php echo $users['competences']; ?>
                </h3>
            </div>
            <div class="box3">
               
            </div>
            
        </div>

       
    </section>



    <section class="section2 menu" id="menu" >
    <img class="img23" id="img23" src="../image/menu n.png" alt="">
        <div class="container">
            <div class="box1">

                <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">
                <span></span>
                
            </div>
            

            <div class="box3">
           
               
            </div>
        </div>


      
    </section>

    <script>
    // Sélectionne l'élément avec la classe 'img' et l'assigne à img222
    let cache = document.getElementById('img23');

    let section = document.querySelector('.section2')
    // Sélectionne l'élément avec la classe 'ste' et l'assigne à section2
    let section2 = document.getElementById('ste');

    // Sélectionne l'élément avec la classe 'menu' et l'assigne à menu
    let menu1 = document.getElementById('menu');

    // Sélectionne l'élément avec la classe 'img111' et l'assigne à img111
    let img111 = document.getElementById('img24');

    // Ajoute un événement de clic à img222
    cache.addEventListener('click', () => {
        // Lorsque img222 est cliqué, déplace section2 à gauche (visible) et cache menu
        section2.style.left = '0';
        menu1.style.left = '-400px';
    });

    // Ajoute un événement de clic à img111
    img111.addEventListener('click', () => {
        // Lorsque img111 est cliqué, cache section2 et montre menu
        section2.style.left = '-100%';
        menu1.style.left = '0';
    });

</script>