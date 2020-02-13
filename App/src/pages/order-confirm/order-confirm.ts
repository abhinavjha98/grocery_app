import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { HomePage } from '../home/home';

@IonicPage()
@Component({
  selector: 'page-order-confirm',
  templateUrl: 'order-confirm.html',
})
export class OrderConfirmPage {

  orderid:String;

  constructor(public navCtrl: NavController, public navParams: NavParams) {
    this.orderid = navParams.get("OrderId");
    this.clearcart();
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad OrderConfirmPage');
  }

  clearcart(){
    HomePage.cartData = [];
  }

}
