class GoteoAPI {
  
  setToken(token) {
    this.token = token;
  }

  getToken() {
    return this.token;
  }
  
  async login(username, apikey) {
    let response = await fetch( 'https://api.goteo.org/v1/login', {
      headers: {
        'Authorization': 'Basic ' + btoa(username + ":" + apikey)
      }
    });

    if (response.ok) {
      this.setToken(response.json().access_token);
      return true;
    }

    return false;
  }

}