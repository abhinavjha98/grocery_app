import { Injectable } from '@angular/core';
import 'rxjs/add/operator/map';
import { Http,Headers } from '@angular/http';

@Injectable()
export class HkApiproviderProvider {

  /*******************************
 *
 *  Developer : Ajay randhawa
 *  Email : ajayrandhawartg@gmail.com
 *
 *  Please don't share this script on nulled websites
 *  Buy from Envato & appreciate Developer
 *
 * ******************************/

  baseUrl = 'http://localhost/backend/app/';
  data: any;

  imagebaseurl = 'http://localhost/backend/admin/itemimg/';
  bannerbaseurl = 'http://localhost/backend/admin/banner/';

  shipping = 10;

  /*********************************************** */

  constructor(public http: Http) {
  }


  postData(credentials, type){
    return new Promise((resolve, reject) =>{
      let headers = new Headers();
      this.http.post(this.baseUrl+type, JSON.stringify(credentials), {headers: headers}).
      subscribe(res =>{
        resolve(res.json());
      }, (err) =>{
        reject(err);
      });
    });
  }

  getimage(){
    return this.imagebaseurl;
  }

  getbanner(){
    return this.bannerbaseurl;
  }

  getshippingChargers(){
    return this.shipping;
  }

}
