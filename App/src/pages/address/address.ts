import { Component } from "@angular/core";
import {
  IonicPage,
  NavController,
  NavParams,
  AlertController,
  LoadingController,
  ToastController
} from "ionic-angular";
import { OrderConfirmPage } from "../order-confirm/order-confirm";
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";
import { Http } from "@angular/http";
import { HomePage } from '../home/home';

@IonicPage()
@Component({
  selector: "page-address",
  templateUrl: "address.html"
})
export class AddressPage {

  resposeData :any;
  orderdataSet:any;

  public userDetails:any;

  userData = {
    fname: "",
    address: "",
    mobile: ""
  };

  order = {
    token: "",
    user_id:"",
    fname: "",
    address: "",
    mobile: "",
    items : []
  }

  constructor(
    public alertCtrl: AlertController,
    public navCtrl: NavController,
    public auth: HkApiproviderProvider,
    public toastCtrl: ToastController,
    public navParams: NavParams,
    public loadingCtrl: LoadingController,
    public http: Http
  ) {

    const data = JSON.parse(localStorage.getItem('userData'));
    this.userDetails = data.userData;

    this.userData.mobile = this.userDetails.mobile;
    this.userData.fname = this.userDetails.fname;
    this.userData.address = this.userDetails.address;

  }


  onSubmit(){

    let zest = this.loadingCtrl.create({
      content: "Submitting Order..",
      duration:20000,
      spinner:'crescent'
    });  

    zest.present();
    
    this.order.fname = this.userData.fname;
    this.order.mobile = this.userData.mobile;
    this.order.address = this.userData.address;
    this.order.token = this.userDetails.token;
    this.order.user_id = this.userDetails.user_id;

    this.order.items = HomePage.cartData;

    console.log(this.order);

    if(this.order.fname != "" && this.order.address != "" && this.order.mobile != "" && this.order.user_id != "" && this.order.token != ""){
    this.auth.postData(this.order, "placeorder").then(
      result => {
        zest.dismiss();
        this.resposeData = result;
        if(this.resposeData.success){
          this.orderdataSet = this.resposeData.success;
          this.navCtrl.setRoot(OrderConfirmPage,{ OrderId: this.orderdataSet });
        }else{
          console.log("Error");
        }
      },
      err => {
        zest.dismiss();
      }
    );
    }
    else{
        let alert = this.alertCtrl.create({
          title: 'Something Wrong',
          subTitle: 'Please Give Valid Details',
          buttons: ['Dismiss']
        });
        alert.present();
        zest.dismiss();
    }
  }

}

