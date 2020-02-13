import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController } from 'ionic-angular';
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";

@IonicPage()
@Component({
  selector: 'page-order-placed',
  templateUrl: 'order-placed.html',
})
export class OrderPlacedPage {

  public userDetails:any;

  postData = {
    token: "",
    user_id:"",
    orderid: ""
  };

  viewData={
    orderid : "",
    fname : "",
    lname : "",
    area : "",
    address : "",
    mobile : "",
    ordertime : ""
  };
  resposeData:any;
  orderDetail:any;

  constructor(private loadingCtrl: LoadingController, private auth: HkApiproviderProvider, public navCtrl: NavController, public navParams: NavParams) {

      const data = JSON.parse(localStorage.getItem('userData'));
      this.userDetails = data.userData;

      this.postData.user_id = this.userDetails.user_id;
      this.postData.token = this.userDetails.token;

      this.postData.orderid = navParams.get("orderid");
      this.viewData.orderid = navParams.get("orderid");
      this.viewData.fname = navParams.get("fname");
      this.viewData.lname = navParams.get("lname");
      this.viewData.area = navParams.get("area");
      this.viewData.address = navParams.get("address");
      this.viewData.mobile = navParams.get("mobile");
      this.viewData.ordertime = navParams.get("ordertime");
      this.getOrderDetail();
  }

  getOrderDetail(){
    let zest = this.loadingCtrl.create({
      content: "Getting Data..",
      duration:20000,
      spinner:'crescent'
    });  
  
    zest.present();
    this.auth.postData(this.postData, "fetchorderdetail").then(
      result => {
        this.resposeData = result;
        this.orderDetail = this.resposeData.OrderDetail;
        zest.dismiss();
      },
      err => {
        zest.dismiss();
      }
    )
    }


}
