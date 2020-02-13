import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { ProductDescPage } from './product-desc';

@NgModule({
  declarations: [
    ProductDescPage,
  ],
  imports: [
    IonicPageModule.forChild(ProductDescPage),
  ],
})
export class ProductDescPageModule {}
