import { Component } from "@angular/core";
import { NavController, NavParams, LoadingController,ToastController, MenuController } from "ionic-angular";
import { CartPage } from "../cart/cart";
import { ProductsPage } from "../products/products";
import { HkApiproviderProvider } from "../../providers/hk-apiprovider/hk-apiprovider";
import { ProductDescPage } from "../product-desc/product-desc";
import { ProductSearchPage } from "../product-search/product-search";
import { OffersPage } from '../offers/offers';

@Component({
  selector: "page-home",
  templateUrl: "home.html"
})
export class HomePage {
  public resposeData: any;
  userDetails:any;

  static cartData = [];
  cartCounter  = 0;

  public baseUrlImage:String;
  public baseUrlBanner:String;

  public homeproductdataSet: any;
  public categoryFullData: any;
  public bannerFullData: any;

  public productFullData: any = [];
  moreProducts: any[];
  page: number;
  searchQuery: string = "";
  categoryList: any = "";
  constructor(
    public navCtrl: NavController,
    private auth: HkApiproviderProvider,
    public navPram: NavParams,
    public toastCtrl : ToastController,
    public loadingCtrl : LoadingController,
    public menuCtrl : MenuController
  ) {
    const data = JSON.parse(localStorage.getItem('userData'));
    this.userDetails = data.userData;
    this.menuCtrl.enable(true);
    this.baseUrlImage = auth.getimage();
    this.baseUrlBanner = auth.getbanner();
    this.homepageproducts();

  }

  itemSelected(category) {
    this.navCtrl.push(ProductsPage, { category: category });
  }

  gotocart(){
    this.navCtrl.push(CartPage);
  }

  homepageproducts() {
    let zest = this.loadingCtrl.create({
      content: "Fetching Data..",
      duration:20000,
      spinner:'crescent'
    });  
    zest.present();

    this.auth.postData(this.userDetails, "gethomepage").then(
      result => {
        this.resposeData = result;
        this.homeproductdataSet = this.resposeData.HomeData;
        this.categoryFullData = this.resposeData.CateData;
        this.bannerFullData = this.resposeData.BannData;
        zest.dismiss();
      },
      err => {
        zest.dismiss();
      }
    );
  }

  openProductDetailPage(
    itemId: String,
    itemName: String,
    itemImage: String,
    itemDesc: String,
    itemQuantity: String,
    itemQuantityType: String,
    itemPrice: String
  ) {
    this.navCtrl.push(ProductDescPage, {
      itemId: itemId,
      itemName: itemName,
      itemDesc: itemDesc,
      itemQuantity: itemQuantity,
      itemQuantityType: itemQuantityType,
      itemPrice: itemPrice,
      itemImage: itemImage
    });
  }

  gotoproducts(category: string) {
    this.navCtrl.push(ProductsPage, {
      category: category
    });
  }

  addToCart(itemid:any, itemname:any, itemquantity:any, itemquantitytype:any, itemprice:any, itemImage:any) {
    HomePage.storeToCart(itemid,itemname,itemquantity,itemquantitytype,itemprice, itemImage);
    this.showAddCartMsg();
  }

  public static storeToCart(itemid, itemname, itemquantity, itemquantitytype, itemprice, itemImage) {

    var Mquantity  = "1";
    var itemtotal = itemprice;
    HomePage.cartData.push({itemid, itemname, itemquantity, itemquantitytype, itemprice, itemtotal, itemImage, Mquantity});
  }


  showAddCartMsg(){
    let toast = this.toastCtrl.create({
      message: "Product Added to Cart!",
      duration: 3000,
      position: 'bottom'
    });

    toast.present();
  }

  gotoSearch(){
    this.navCtrl.push(ProductSearchPage);
  }

  cartCounterManager(){
    return HomePage.cartData.length
  }

  gotoOffer(){
    this.navCtrl.push(OffersPage);
  }
  
}
