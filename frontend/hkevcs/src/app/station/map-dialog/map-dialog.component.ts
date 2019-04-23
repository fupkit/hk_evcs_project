import { Component, OnInit, Inject } from '@angular/core';
import { MAT_DIALOG_DATA } from '@angular/material';
import { Station } from '../station';

@Component({
  selector: 'app-map-dialog',
  templateUrl: './map-dialog.component.html',
  styleUrls: ['./map-dialog.component.scss']
})
export class MapDialogComponent implements OnInit {
  station : Station;
  constructor(@Inject(MAT_DIALOG_DATA) public data) { 
  }

  ngOnInit() {
    this.station = this.data.station;
    
    console.log(this.station);
  }

}
