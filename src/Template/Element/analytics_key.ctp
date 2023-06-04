<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="<?=API['GOOGLE_ANALYTICS_API']?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?=API['GOOGLE_ANALYTICS_UA_ID']?>');
</script>