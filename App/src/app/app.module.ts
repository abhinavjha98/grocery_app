import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { IonicStorageModule } from '@ionic/storage';
import { MyApp } from './app.component';
import { LoginPage } from '../pages/login/login';
import { RegisterPage } from '../pages/register/register';
import { HomePage } from '../pages/home/home';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { AddressPage } from '../pages/address/address';
import { CartPage } from '../pages/cart/cart';
import { NotificationsPage } from '../pages/notifications/notifications';
import { OrderHistoryPage } from '../pages/order-history/order-history';
import { OrderPlacedPage } from '../pages/order-placed/order-placed';
import { ProductDescPage } from '../pages/product-desc/product-desc';
import { ProductSearchPage } from '../pages/product-search/product-search';
import { ValidatorsModule } from '../validators/validators.module';
import { TextMaskModule } from 'angular2-text-mask';
import { OrderConfirmPage } from '../pages/order-confirm/order-confirm';
import { ContactPage } from '../pages/contact/contact';
import { OffersPage } from '../pages/offers/offers';
import { FeedbackPage } from '../pages/feedback/feedback';
import { ProductsPage } from '../pages/products/products';
import { HkApiproviderProvider } from '../providers/hk-apiprovider/hk-apiprovider';
import { HttpModule } from '@angular/http';

@NgModule({
  declarations: [
    MyApp,
    LoginPage,
    RegisterPage,
    HomePage,
    AddressPage,
    CartPage,
    NotificationsPage,
    OrderHistoryPage,
    OrderPlacedPage,
    ProductDescPage,
    ProductSearchPage,
    OrderConfirmPage,
    ContactPage,
    ProductsPage,
    FeedbackPage,
    OffersPage
  ],
  imports: [
    BrowserModule,
    IonicModule.forRoot(MyApp),
    IonicStorageModule.forRoot(),
    ValidatorsModule,
    TextMaskModule,
    HttpModule
  ],
  exports: [

  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    LoginPage,
    RegisterPage,
    HomePage,
    AddressPage,
    CartPage,
    NotificationsPage,
    OrderHistoryPage,
    OrderPlacedPage,
    ProductDescPage,
    ProductSearchPage,
    OrderConfirmPage,
    ContactPage,
    ProductsPage,
    FeedbackPage,
    OffersPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
    HkApiproviderProvider
  ]
})
export class AppModule {}
