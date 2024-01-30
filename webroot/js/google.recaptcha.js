function onSubmit(token) {
  document.getElementsByName('recaptcha_token')[0].value = token;

  document.getElementsByName('recaptcha_action')[0].value
   = document.getElementsByName('recaptcha_submit')[0].dataset.action;
  document.getElementById("recaptcha-form").submit();
}