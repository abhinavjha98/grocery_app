import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { ProductSearchPage } from './product-search';

@NgModule({
  declarations: [
    ProductSearchPage,
  ],
  imports: [
    IonicPageModule.forChild(ProductSearchPage),
  ],
})
export class ProductSearchPageModule {}
