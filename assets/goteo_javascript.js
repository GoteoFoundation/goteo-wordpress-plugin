async function checkApiKey() {

  if (event.submitter.id == 'check_api')
    event.preventDefault();
  else 
    return true;

  var goteo_base_api_url = event.target.goteo_base_api_url.value;
  var goteo_user = event.target.goteo_user.value;
  var goteo_key = event.target.goteo_key.value;

  var infoMessages = document.getElementById('infoMessages');
  infoMessages.classList.remove( ...infoMessages.classList);
  infoMessages.innerHTML = '';

  var goteo = new GoteoAPI(goteo_base_api_url);

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