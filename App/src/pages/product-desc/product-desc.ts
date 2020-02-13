import { Component } from "@angular/core";
import {
  IonicPage,
  NavController,
  NavParams,
  ToastController
} from "ionic-angular";
import { CartPage } from "../cart/cart";
import { HomePage } from "../home/home";
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";

@IonicPage()
@Component({
  selector: "page-product-desc",
  templateUrl: "product-desc.html"
})
export class ProductDescPage {
  itemId: string;
  itemName: string;
  itemDesc: String;
  itemQuantity: string;
  itemQuantityType: string;
  itemPrice: string;
  itemImage: string;

  public baseUrlImage: String;

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    public toastController: ToastController,
    private auth: HkApiproviderProvider
  ) {
    
    this.baseUrlImage = auth.getimage();

    this.itemId = navParams.get("itemId");
    this.itemName = navParams.get("itemName");
    this.itemDesc = navParams.get("itemDesc");
    this.itemQuantity = navParams.get("itemQuantity");
    this.itemQuantityType = navParams.get("itemQuantityType");
    this.itemPrice = navParams.get("itemPrice");
    this.itemImage = navParams.get("itemImage");
  }

  ionViewDidLoad() {}

  openCartPage() {
    this.navCtrl.push(CartPage);
  }

  addtocart(itemid:any, itemname:any, itemquantity:any, itemquantitytype:any, itemprice:any, itemimage:any) {
    HomePage.storeToCart(
      itemid,
      itemname,
      itemquantity,
      itemquantitytype,
      itemprice,
      itemimage
    );
    this.showAddCartMsg();
  }

  showAddCartMsg(){
    let toast = this.toastController.create({
      message: "Product Added to Cart!",
      duration: 3000,
      position: 'bottom'
    });

    toast.present();
  }

  cartCounterManager(){
    return HomePage.cartData.length
  }
}
