import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController, MenuController } from 'ionic-angular';
import { HomePage } from '../home/home'; 
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";
import { RegisterPage} from '../register/register'; 


@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {

  resposeData : any;
  userData = {"email":"", "password":""};

  constructor(public navCtrl: NavController, public navParams: NavParams, private menuCtrl: MenuController, public authService: HkApiproviderProvider, public alertCtrl: AlertController, private loadingCtrl: LoadingController) {
      this.menuCtrl.enable(false);
  }


  login(){
    let loader = this.loadingCtrl.create({
          content: "Fetching Server",
          duration: 10000
        });  
        loader.present();
    if(this.userData.email != "" && this.userData.password != ""){
     this.authService.postData(this.userData, "login").then((result) =>{
      loader.dismiss();
     this.resposeData = result;
     if(this.resposeData.userData){
            localStorage.setItem('userData', JSON.stringify(this.resposeData) );
            this.navCtrl.setRoot(HomePage);
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

  onregister(){
    this.navCtrl.setRoot(RegisterPage);
  }

}
