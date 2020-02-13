import { Component } from "@angular/core";
import {
  IonicPage,
  NavController,
  NavParams,
  LoadingController
} from "ionic-angular";
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";

@IonicPage()
@Component({
  selector: "page-notifications",
  templateUrl: "notifications.html"
})
export class NotificationsPage {
  public resposeData: any;
  userDetails: any;

  postData = {
    user_id:"",
    token: ""
  };

  public NotidataSet: any;

  constructor(
    private loadingCtrl: LoadingController,
    public navCtrl: NavController,
    public navParams: NavParams,
    public auth: HkApiproviderProvider
  ) {
    const data = JSON.parse(localStorage.getItem('userData'));
    this.userDetails = data.userData;

    this.postData.user_id = this.userDetails.user_id;
    this.postData.token = this.userDetails.token;
    
    this.getField();
  }

  getField() {
    let zest = this.loadingCtrl.create({
      content: "Getting Notification..",
      duration: 20000,
      spinner: "crescent"
    });

    zest.present();
    this.auth.postData(this.postData, "getnotification").then(
      result => {
        this.resposeData = result;
        this.NotidataSet = this.resposeData.NotiData;
        console.log(this.NotidataSet);
        zest.dismiss();
      },
      err => {
        zest.dismiss();
      }
    );
  }
}
