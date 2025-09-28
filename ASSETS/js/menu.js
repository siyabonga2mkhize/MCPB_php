    // --- COMMON ELEMENTS ---
        const menuOverlay = document.getElementById('sideMenu'); // L1 Main
        const openMenuBtn = document.querySelector('.menu-btn'); 
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const body = document.body;

        // --- LEVEL 2 ELEMENTS (FOOD) ---
        const foodMenuOverlay = document.getElementById('foodMenu');
        const foodLinkInMainMenu = document.getElementById('foodLink'); 
        const backToMainMenuBtn = document.getElementById('backToMainMenuBtn');
        const closeFoodMenuBtn = document.getElementById('closeFoodMenuBtn');
        const meatLinkInFoodMenu = document.getElementById('meatLink');
        
        // --- LEVEL 3 ELEMENTS (MEAT) ---
        const meatMenuOverlay = document.getElementById('meatMenu');
        const backToFoodMenuBtn = document.getElementById('backToFoodMenuBtn');
        const closeMeatMenuBtn = document.getElementById('closeMeatMenuBtn');

        // --- NEW: L3 Final Links (Beef, Poultry, etc.) ---
        // Get all final links in the Meat menu to handle navigation
        const meatFinalLinks = meatMenuOverlay.querySelectorAll('.sub-category-link');
        
        // --- TOGGLE FUNCTIONS ---

        function openMainMenu() {
            menuOverlay.classList.add('active');
            body.style.overflow = 'hidden'; 
        }

        function closeAllMenus() {
            menuOverlay.classList.remove('active');
            foodMenuOverlay.classList.remove('active');
            meatMenuOverlay.classList.remove('active');
            body.style.overflow = ''; 
        }

        function openFoodMenu() {
            menuOverlay.classList.remove('active'); 
            meatMenuOverlay.classList.remove('active'); 
            foodMenuOverlay.classList.add('active'); 
            body.style.overflow = 'hidden';
        }
        
        function openMeatMenu() {
            foodMenuOverlay.classList.remove('active'); 
            meatMenuOverlay.classList.add('active'); 
            body.style.overflow = 'hidden';
        }

        // --- EVENT LISTENERS ---
        
        // 1. Level 1 (Main Menu) Controls
        openMenuBtn.addEventListener('click', openMainMenu);
        closeMenuBtn.addEventListener('click', closeAllMenus);

        menuOverlay.addEventListener('click', function(e) {
            if (e.target === menuOverlay) {
                closeAllMenus();
            }
        });

        // 2. Level 2 (Food Menu) Controls
        
        // A. Open Food menu from Main Menu
        foodLinkInMainMenu.addEventListener('click', function(e) {
            e.preventDefault(); 
            openFoodMenu();
        });

        // B. Back button on Food Menu (L2 -> L1)
        backToMainMenuBtn.addEventListener('click', function() {
            foodMenuOverlay.classList.remove('active');
            openMainMenu();
        });

        // C. Close button on Food Menu (L2 -> Close All)
        closeFoodMenuBtn.addEventListener('click', closeAllMenus);

        // 3. Level 3 (Meat Menu) Controls
        
        // A. Open Meat menu from Food Menu
        meatLinkInFoodMenu.addEventListener('click', function(e) {
            e.preventDefault(); 
            openMeatMenu();
        });
        
        // B. Back button on Meat Menu (L3 -> L2)
        backToFoodMenuBtn.addEventListener('click', function() {
            meatMenuOverlay.classList.remove('active');
            openFoodMenu(); 
        });

        // C. Close button on Meat Menu (L3 -> Close All)
        closeMeatMenuBtn.addEventListener('click', closeAllMenus);

        meatMenuOverlay.addEventListener('click', function(e) {
            if (e.target === meatMenuOverlay) {
                closeAllMenus();
            }
        });

        // D. Handle Clicks on final Category links (Beef, Poultry, etc.)
        meatFinalLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Do NOT preventDefault here, let the browser navigate
                // but first, close the menus immediately for a clean transition.
                closeAllMenus(); 
                // The browser will now navigate to the link's href (e.g., meat_beef.php)
            });
        });
        
        // Optional: Close on ESC key for any menu
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllMenus();
            }
        });
        
        // --- SUCCESS MODAL LOGIC (Existing) ---
        const modal = document.getElementById('successModal');
        if (modal) {
            setTimeout(() => {
                if (window.history.replaceState) {
                    const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    window.history.replaceState({path: cleanUrl}, '', cleanUrl);
                }
            }, 500);
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    window.location.href = 'index.php'; 
                }
            });
        }