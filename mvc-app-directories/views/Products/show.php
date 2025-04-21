<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/products">Products</a></li>
    </ul>
</nav>

<h1>Show Product Page</h1>

<h2><?= htmlspecialchars($product["name"]) ?></h2>
<p><?= htmlspecialchars($product["description"]) ?></p>
