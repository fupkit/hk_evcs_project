import { Component, OnInit, Inject } from '@angular/core';
import { MAT_DIALOG_DATA } from '@angular/material';
import { Station } from '../station';

@Component({
  selector: 'app-map-dialog',
  templateUrl: './map-dialog.component.html',
  styleUrls: ['./map-dialog.component.scss']
})
export class MapDialogComponent implements OnInit {

  markerImg = {
    url: '../../assets/EV-Charging.png',
    scaledSize: {
      width: 30,
      height: 45
    }
  }
  lats: number[] = [];
  lngs: number[] = [];
  constructor(@Inject(MAT_DIALOG_DATA) public data) {
  }

  ngOnInit() {
    for (let st of this.data.stations) {
      this.lats.push(st.lat);
      this.lngs.push(st.lng);
    }

  }

}
