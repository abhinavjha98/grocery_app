import { Component } from '@angular/core';
import { LoadingController, NavController, ModalController, AlertController, ToastController, NavParams } from 'ionic-angular';
import { ProductDescPage } from '../product-desc/product-desc';
import { HomePage } from '../home/home';
import { HkApiproviderProvider } from '../../providers/hk-apiprovider/hk-apiprovider';
import { CartPage } from "../cart/cart";


@Component({
  templateUrl: 'products.html',
})

export class ProductsPage {
 
  public resposeData : any;
  public userDetails: any;
  postData={
    "user_id":"",
    "token":"",
    "categoryname":"",
  }

  public baseUrlImage:String;
  categoryid :string;
  
  public dataSetitems : any;
  public categoryFullData : any = [];

  products:any[];
  category:any="";
  iteminfo:any="";
  itemdatafull:any="";
  itemFullArray:any=[];

	constructor(
		public navCtrl: NavController, 
		public navParams: NavParams, 
		public modalCtrl: ModalController,
    public alertCtrl: AlertController,
    public auth:HkApiproviderProvider,
    public toastController:ToastController,
    public loadingCtrl : LoadingController
	) {
    this.baseUrlImage = auth.getimage();
    const data = JSON.parse(localStorage.getItem('userData'));
    this.userDetails = data.userData;

    this.postData.user_id = this.userDetails.user_id;
    this.postData.token = this.userDetails.token;
    
    this.postData.categoryname=this.navParams.get('category');
    this.categoryid = navParams.get('category');
    this.postData.categoryname = this.categoryid;
    console.log(this.categoryid);
    this.getcategorydata();
	}

  gotocart(){
    this.navCtrl.push(CartPage);
  }

  public getcategorydata()
{
  let zest = this.loadingCtrl.create({
    content: "Getting Data..",
    duration:20000,
    spinner:'crescent'
  });  

  zest.present();

    this.auth.postData(this.postData, "categoryfilter").then((result) => {
        this.resposeData = result;
        this.categoryFullData = this.resposeData.CateFilterData;
        zest.dismiss();
    }, (err) => {
      zest.dismiss();
    });
  }

  openProductDetailPage(itemId:String,itemName:String, itemImage:String,itemDesc:String,itemQuantity:String, itemQuantityType:String, itemPrice:String){
    this.navCtrl.push(ProductDescPage,{
      itemId : itemId,
      itemName : itemName,
      itemDesc : itemDesc,
      itemQuantity :itemQuantity,
      itemQuantityType:itemQuantityType,
      itemPrice : itemPrice,
      itemImage : itemImage
    });
  }


  addToCartProd(itemid:any, itemname:any, itemquantity:any, itemquantitytype:any, itemprice:any, itemimage:any) {
    HomePage.storeToCart(itemid,itemname,itemquantity,itemquantitytype,itemprice, itemimage);
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
