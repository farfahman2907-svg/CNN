 <footer class="footer">
    © <?php echo date("Y"); ?> NEON CNN — Modern Digital News
</footer>

<script>
const observer = new IntersectionObserver(entries=>{
    entries.forEach(entry=>{
        if(entry.isIntersecting){
            entry.target.classList.add("show");
        }
    });
});
document.querySelectorAll(".fade").forEach(el=>observer.observe(el));
</script>

</body>
</html>
