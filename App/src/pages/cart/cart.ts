import { Component } from "@angular/core";
import {
  IonicPage,
  NavController,
  NavParams,
  ToastController
} from "ionic-angular";
import { AddressPage } from "../address/address";
import { HomePage } from '../home/home';
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";

@IonicPage()
@Component({
  selector: "page-cart",
  templateUrl: "cart.html"
})
export class CartPage {

  shipping = 0;
  amount = 0;
  finalamount = 0;

  public showtxt:boolean;
  public showcartdata:boolean;

  public baseUrlImage:String;

  cartquantity = 1;

  finalcartdata;

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    public toastController: ToastController,
    private auth: HkApiproviderProvider
  ) {
    this.baseUrlImage = auth.getimage();
    this.finalcartdata = HomePage.cartData;
    if(this.finalcartdata.length == 0){
      this.showtxt = true;
      this.showcartdata = false;
    }else{
      this.showtxt = false;
      this.showcartdata = true;
    }
    this.shipping = auth.getshippingChargers();
    this.calculatecart();
  }

  ionViewDidLoad() {
    console.log("ionViewDidLoad CartPage");
  }
  

  goToCheckout() {
    this.navCtrl.push(AddressPage);
  }

  calculatecart(){
    this.amount = 0;
    for(let item of this.finalcartdata){
      this.amount += parseInt(item.itemprice) * parseInt(item.Mquantity); 
      console.log(this.amount);
  }
  this.finalamount = +this.amount + +this.shipping;
}

  emptycart(){
    HomePage.cartData = [];
    this.navCtrl.popToRoot();
  }

  changeQty(i, change){

      let qty = parseInt(this.finalcartdata[i].Mquantity);
      qty += parseInt(change);

      if(qty != 0){
        this.finalcartdata[i].Mquantity = qty.toString();
        this.calculatecart();
      }
  
        this.toastController.create({
          message: "Cart Updated.",
          duration: 2000
        }).present();
    }
}
