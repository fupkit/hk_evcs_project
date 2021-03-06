import { Component, OnInit } from '@angular/core';
import { Station } from '../station/station';
import { ApiService } from '../api-service.service';
import { DataShareService } from '../data-share.service';
import { District } from '../district';
import { MapDialogComponent } from '../station/map-dialog/map-dialog.component';
import { MatDialog } from '@angular/material';
import { AddDialogComponent } from './add-dialog/add-dialog.component';

@Component({
  selector: 'app-body',
  templateUrl: './body.component.html',
  styleUrls: ['./body.component.scss']
})
export class BodyComponent implements OnInit {
  public static en_areas: string[] = [];
  public static tc_areas: string[] = [];
  public static en_districts: District[] = [];
  public static tc_districts: District[] = [];

  language: string = 'EN';

  stations: Station[] = [];
  en_stations: Station[] = [];
  tc_stations: Station[] = [];
  constructor(private service: ApiService,
    private share: DataShareService,
    public dialog: MatDialog) { }

  async ngOnInit() {
    await this.service.getArea('EN').subscribe(res => {
      let a = JSON.stringify(res);
      let r = JSON.parse(a);
      if (r.result) {
        r.areas.forEach(a => {
          BodyComponent.en_areas.push(a.area);
          this.initPage();
        });
      }
    });
    
  }
  initPage() {
    this.service.getArea('TC').subscribe(res => {
      let a = JSON.stringify(res);
      let r = JSON.parse(a);
      if (r.result) {
        r.areas.forEach(a => {
          BodyComponent.tc_areas.push(a.area);
        });
      }
    });
    this.service.getDistrict('EN').subscribe(res => {
      let a = JSON.stringify(res);
      let r = JSON.parse(a);
      if (r.result) {
        r.districts.forEach(d => {
          BodyComponent.en_districts.push(d);
        });
      }
    });
    this.service.getDistrict('TC').subscribe(res => {
      let a = JSON.stringify(res);
      let r = JSON.parse(a);
      if (r.result) {
        r.districts.forEach(d => {
          BodyComponent.tc_districts.push(d);
        });
      }
    });
    this.service.getAll().subscribe(res => {
      this.parseStation(res);
    });
    this.share.sharedLang.subscribe((lang) => {
      this.language = lang.toUpperCase();
    });
  }
  searchStation(key: string) {
    this.service.search(key).subscribe(res => {
      this.parseStation(res);
    });
  }

  parseStation(res) {
    let a = JSON.stringify(res);
    let r = JSON.parse(a);
    this.stations = r.stations;
    this.en_stations = this.stations.filter(s => { return s.lang.toUpperCase() == "EN"; });
    this.tc_stations = this.stations.filter(s => { return s.lang.toUpperCase() == "TC"; });
  }

  promptMap() {
    const dialogRef = this.dialog.open(MapDialogComponent, {
      width: '600px',
      data: {
        stations: this.stations
      }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('Map dialog was closed');
    });
  }

  promptAddStation() {
    const addDigRef = this.dialog.open(AddDialogComponent, {
      width: '600px'
    });

    addDigRef.afterClosed().subscribe(result => {
      console.log('Add dialog was closed');
      if(result) {
        this.ngOnInit();
      }
    });
  }


}
