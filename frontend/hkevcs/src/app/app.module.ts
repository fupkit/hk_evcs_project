import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatButtonModule, MatCheckboxModule, MatToolbarModule, MatSidenavModule, MatIconModule, MatListModule } from '@angular/material';
import { MatCardModule } from '@angular/material/card';
import { MatDialogModule } from '@angular/material/dialog';
import { ReactiveFormsModule } from '@angular/forms';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule, MatTableModule, MatPaginatorModule, MatSortModule } from '@angular/material';
import { MatTabsModule } from '@angular/material/tabs';
import { MatRadioModule } from '@angular/material/radio';
import { MatMenuModule } from '@angular/material/menu';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { MatSelectModule } from '@angular/material/select';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material';
import { MatButtonToggleModule } from '@angular/material/button-toggle';
import { MatBadgeModule } from '@angular/material/badge';
import { MatSlideToggleModule } from '@angular/material/slide-toggle';

import { LayoutModule } from '@angular/cdk/layout';
import { BodyComponent } from './body/body.component';
import { StationComponent } from './station/station.component';
import { ApiService } from './api-service.service';

import { AgmCoreModule } from '@agm/core';
import { environment } from "../environments/environment";
import { MapDialogComponent } from './station/map-dialog/map-dialog.component';
import { TopNavComponent } from './top-nav/top-nav.component';
import { UpdateDialogComponent } from './station/update-dialog/update-dialog.component';
import { DeleteDialogComponent } from './station/delete-dialog/delete-dialog.component';
import { AddDialogComponent } from './body/add-dialog/add-dialog.component'

@NgModule({
  declarations: [
    AppComponent,
    BodyComponent,
    StationComponent,
    MapDialogComponent,
    TopNavComponent,
    UpdateDialogComponent,
    DeleteDialogComponent,
    AddDialogComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatButtonModule,
    MatCheckboxModule,
    LayoutModule,
    MatToolbarModule,
    MatSidenavModule,
    MatIconModule,
    MatListModule,
    MatCardModule,
    MatDialogModule,
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatTabsModule,
    MatRadioModule,
    HttpClientModule,
    MatMenuModule,
    MatSnackBarModule,
    MatTableModule,
    MatPaginatorModule,
    MatSortModule,
    MatSelectModule,
    MatGridListModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatButtonToggleModule,
    MatBadgeModule,
    MatSlideToggleModule,
    AgmCoreModule.forRoot({
      apiKey: environment.gmapApiKey
    })
  ],
  providers: [ApiService],
  bootstrap: [AppComponent],
  entryComponents: [MapDialogComponent, UpdateDialogComponent, DeleteDialogComponent, AddDialogComponent]
})
export class AppModule { }
