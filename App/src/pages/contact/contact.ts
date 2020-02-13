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
  selector: "page-contact",
  templateUrl: "contact.html"
})
export class ContactPage {
  private todo: FormGroup;
  public userDetails:any;

  postData = {
    token: "",
    user_id:"",
    cname: "",
    cmobile: "",
    cmsg: ""
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
      cname: ["", Validators.required],
      cmobile: ["", Validators.required],
      cmsg: ["", Validators.required]
    });
  }

  logForm() {

    let zest = this.loadingCtrl.create({
      content: "Sending Message..",
      duration:20000,
      spinner:'crescent'
    });  

    zest.present();

    this.postData.cname = this.todo.value.cname;
    this.postData.cmobile = this.todo.value.cmobile;
    this.postData.cmsg = this.todo.value.cmsg;

    this.auth.postData(this.postData, "sendmessage").then(
      result => {
        zest.dismiss();
        this.resposeData = result;
        if (this.resposeData.success) {
          this.ticket = this.resposeData.success;
          this.messagesend();
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

  messagesend() {
    let alert = this.alertCtrl.create({
      title: "Message Send",
      subTitle: "Thanks for getting in touch. We will contact you shortly!",
      buttons: ["Close"]
    });
    alert.present();
  }
}
