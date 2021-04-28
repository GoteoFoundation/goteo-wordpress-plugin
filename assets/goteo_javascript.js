async function checkApiKey(event) {

  if (event.submitter.id == 'check_api')
    event.preventDefault();
  else 
    return true;

  var goteo_user = event.target.goteo_user.value;
  var goteo_key = event.target.goteo_key.value;

  var infoMessages = document.getElementById('infoMessages');
  infoMessages.classList.remove( ...infoMessages.classList);
  infoMessages.innerHTML = '';

  var goteo = new GoteoAPI();

  if (await goteo.login(goteo_user, goteo_key)) {
    infoMessages.innerHTML = "Success autenticating";
    infoMessages.classList.add('notice','notice-success');
    return true;
  } else {
    infoMessages.innerHTML = "Error autenticating";
    infoMessages.classList.add('notice','notice-error');
    return false;
  }

}