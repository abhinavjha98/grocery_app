import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, MenuController, AlertController, LoadingController } from 'ionic-angular';
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";
import { LoginPage } from '../login/login';

@IonicPage()
@Component({
  selector: 'page-register',
  templateUrl: 'register.html',
})
export class RegisterPage {

  resposeData : any;
  userData = {"name":"","mobile":"","address":"","email":"", "password":""};

  constructor(public navCtrl: NavController, public navParams: NavParams, private menuCtrl: MenuController, public authService: HkApiproviderProvider, public alertCtrl: AlertController, private loadingCtrl: LoadingController) {
      this.menuCtrl.enable(false);
  }


 register(){
    let loader = this.loadingCtrl.create({
          content: "Fetching Server",
          duration: 10000
        });  
        loader.present();
    if(this.userData.email != "" && this.userData.password != "" && this.userData.name != "" && this.userData.mobile != "" && this.userData.address != ""){
     this.authService.postData(this.userData, "register").then((result) =>{
      loader.dismiss();
     this.resposeData = result;
     if(this.resposeData.userData){
            this.showsucessinfo();
            this.navCtrl.setRoot(LoginPage);
        }else if(this.resposeData.error){
          this.showalertinfo();
        } 
     }, (err) => {
     loader.dismiss();
      this.showalertinfo();
       //Connection failed message
     });
    }
    else{
     loader.dismiss();
     this.showalertinfo();
    }
   
   }

  showalertinfo(){
    let alert = this.alertCtrl.create({
      title:"Notification",
      subTitle:"Give Valid Information",
      buttons:["OK"]
    });
    alert.present();
  }

  showsucessinfo(){
    let alert = this.alertCtrl.create({
      title:"Done",
      subTitle:"Registration Successful",
      buttons:["OK"]
    });
    alert.present();
  }

  onlogin(){
    this.navCtrl.setRoot(LoginPage);
  }

}
