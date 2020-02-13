import { Component, ViewChild } from '@angular/core';
import { Nav, Platform, App, LoadingController, AlertController, ToastController } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { LoginPage } from '../pages/login/login';
import { RegisterPage } from '../pages/register/register';
import { NotificationsPage } from '../pages/notifications/notifications';
import { OrderHistoryPage } from '../pages/order-history/order-history';
import { ContactPage } from '../pages/contact/contact';
import { FeedbackPage } from '../pages/feedback/feedback';
import { HomePage } from '../pages/home/home';
import { OffersPage } from '../pages/offers/offers';

@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;
  validEmail:any;
  rootPage: any = LoginPage;

  pages: Array<{title: string, component: any}>;

  constructor(public platform: Platform, public app:App, public toastCtrl: ToastController, public loadingCtrl:LoadingController, public alertCtrl:AlertController,  public statusBar: StatusBar, public splashScreen: SplashScreen) {
    this.initializeApp();

  }

  initializeApp() {
    this.platform.ready().then(() => {
      this.statusBar.backgroundColorByHexString('#307722');
      this.splashScreen.hide();
    });
  }
  
  onclickHome(){
    this.nav.setRoot(HomePage);
  }

  onclickMyOrder(){
    this.nav.push(OrderHistoryPage);
  }

  openContact(){
    this.nav.push(ContactPage);
  }

  onclickNoti(){
    this.nav.push(NotificationsPage);
  }

  openfeedback(){
    this.nav.push(FeedbackPage);
  }

  openoffers(){
    this.nav.push(OffersPage);
  }

  logout(){
    this.nav.setRoot(LoginPage);
  }

}
