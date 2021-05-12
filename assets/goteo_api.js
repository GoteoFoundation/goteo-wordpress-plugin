class GoteoAPI {
  
  constructor(url) {
    this.api_base_url = url;
  }

  setToken(token) {
    this.token = token;
  }

  getToken() {
    return this.token;
  }
  
  async login(username, apikey) {
    let response = await fetch( this.api_base_url + '/login', {
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