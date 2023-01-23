<nav class="navbar">
    <div class="brand-title">
        <a id="home-button" href="home.php" 
        title="Go to the Homepage">rate<span class="my">my</span>USCHousing
        </a>
    </div>
    <div class="navbar-links">
        <ul>
            <li>
                <a href="search_form.php">Search</a>
            </li>
            <li>
                <a href="review_form.php">Write a Review</a>
            </li>
            <li>
                <?php if ( !isset($_SESSION['logged_in']) ) : ?>
                    <a href="login.php">Login</a>
                <?php else : ?>
                    <a href="logout.php">Logout</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>