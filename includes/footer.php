</main>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div>
      <h3>PizzaHaus</h3>
      <p>Fresh dough, premium toppings, and neighborhood hospitality.</p>
      <p><strong>Address:</strong> 125 Brick Oven Ave, Food District</p>
      <p><strong>Phone:</strong> +1 (555) 010-7474</p>
    </div>
    <div>
      <h4>Opening Hours</h4>
      <p>Mon - Thu: 11:00 AM - 10:30 PM</p>
      <p>Fri - Sat: 11:00 AM - 12:00 AM</p>
      <p>Sun: 12:00 PM - 10:00 PM</p>
    </div>
    <div>
      <h4>Useful Links</h4>
      <p><a href="<?=BASE_URL?>/menu.php">Order Online</a></p>
      <p><a href="<?=BASE_URL?>/contact.php">Delivery Zones</a></p>
      <p><a href="<?=BASE_URL?>/about.php">Our Story</a></p>
      <p><a href="<?=BASE_URL?>/admin/login.php">Admin Portal</a></p>
    </div>
  </div>
  <div class="footer-bottom">© <?=date('Y')?> PizzaHaus. All rights reserved.</div>
</footer>
<script>
document.querySelector('.menu-toggle')?.addEventListener('click', function(){
  document.querySelector('.site-nav')?.classList.toggle('open');
});
document.querySelectorAll('[data-qty-change]').forEach(function(btn){
  btn.addEventListener('click', function(){
    var input=document.querySelector(btn.dataset.target);
    if(!input) return;
    var current=parseInt(input.value||'1',10);
    input.value=Math.max(1,current+parseInt(btn.dataset.qtyChange,10));
    input.dispatchEvent(new Event('change'));
  });
});
var search=document.querySelector('#menuSearch');
if(search){
  search.addEventListener('input', function(){
    var q=search.value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(function(card){
      card.style.display=card.textContent.toLowerCase().includes(q)?'block':'none';
    });
  });
}
</script>
</body>
</html>
