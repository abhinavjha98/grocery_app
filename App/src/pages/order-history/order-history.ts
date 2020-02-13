import { Component } from "@angular/core";
import {
  IonicPage,
  NavController,
  NavParams,
  AlertController,
  LoadingController
} from "ionic-angular";
import { OrderPlacedPage } from "../order-placed/order-placed";
import { ContactPage } from "../contact/contact";
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";
import { Storage } from '@ionic/storage';

@IonicPage()
@Component({
  selector: "page-order-history",
  templateUrl: "order-history.html"
})
export class OrderHistoryPage {

  public userDetails:any;

  postData = {
    token: "",
    user_id:""
  };


  userHis:any;

  public showtxt:boolean;
  public showHisdata:boolean;

  resposeData: any;
  orderdata:any;

  constructor(
    private auth: HkApiproviderProvider,
    public navCtrl: NavController,
    public navParams: NavParams,
    public alertCtrl: AlertController,
    public loadingCtrl : LoadingController,
    private storage: Storage
  ) {
    const data = JSON.parse(localStorage.getItem('userData'));
    this.userDetails = data.userData;

    this.postData.user_id = this.userDetails.user_id;
    this.postData.token = this.userDetails.token;
    this.getorderhistory();
  }

  openOrderDetailPage(orderid:String, fname:String, lname:String, area:String, address:String, mobile:String, ordertime:String) {
    this.navCtrl.push(OrderPlacedPage,{ orderid : orderid , fname : fname, lname:lname, area:area , address:address , mobile:mobile , ordertime:ordertime});
    console.log(orderid);
  }

  openReturnProduct() {
    this.navCtrl.push(ContactPage);
  }

  getorderhistory() {
    let zest = this.loadingCtrl.create({
      content: "Getting Data..",
      duration:20000,
      spinner:'crescent'
    });  

    zest.present();

    this.auth.postData(this.postData, "fetchorder").then(
      result => {
        this.resposeData = result;
        this.orderdata = this.resposeData.OrderData;
        console.log(this.orderdata.length);
        if(this.orderdata.length == 0){
          this.showtxt = true;
          this.showHisdata = false;
        }else{
          this.showtxt = false;
          this.showHisdata = true;
        }
        zest.dismiss();
      },
      err => {
        zest.dismiss();
      }
    );
  }
}
