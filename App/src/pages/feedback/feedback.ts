import { Component } from "@angular/core";
import {
  IonicPage,
  NavController,
  NavParams,
  LoadingController,
  ToastController,
  AlertController
} from "ionic-angular";
import { Validators, FormBuilder, FormGroup } from "@angular/forms";
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";
import { Http } from "@angular/http";

@IonicPage()
@Component({
  selector: 'page-feedback',
  templateUrl: 'feedback.html',
})
export class FeedbackPage {

  private todo: FormGroup;
  public userDetails: any;

  postData = {
    token: "",
    user_id:"",
    fmsg: ""
  };

  resposeData:any;
  ticket:String;

  constructor(
    public alertCtrl: AlertController,
    public navCtrl: NavController,
    public auth: HkApiproviderProvider,
    public toastCtrl: ToastController,
    public formBuilder: FormBuilder,
    public navParams: NavParams,
    public loadingCtrl: LoadingController,
    public http: Http
  ) {
    const data = JSON.parse(localStorage.getItem('userData'));
    this.userDetails = data.userData;

    this.postData.user_id = this.userDetails.user_id;
    this.postData.token = this.userDetails.token;

    this.todo = this.formBuilder.group({
      fmsg: ["", Validators.required]
    });
  }

  logForm() {

    let zest = this.loadingCtrl.create({
      content: "Sending Feedback..",
      duration:20000,
      spinner:'crescent'
    });  

    zest.present();

    this.postData.fmsg = this.todo.value.fmsg;

    this.auth.postData(this.postData, "sendfeedback").then(
      result => {
        zest.dismiss();
        this.resposeData = result;
        if (this.resposeData.success) {
          this.ticket = this.resposeData.success;
          this.feedbacksend();
          this.navCtrl.pop();
        } else {
          console.log("Error");
        }
      },
      err => {
        zest.dismiss();
      }
    );
  }

  feedbacksend() {
    let alert = this.alertCtrl.create({
      title: "Feedback Send",
      subTitle: "Thanks for Giving Feedback!",
      buttons: ["Close"]
    });
    alert.present();
  }

}

