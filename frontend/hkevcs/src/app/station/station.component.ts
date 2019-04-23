import { Component, OnInit, Input } from '@angular/core';
import { Station } from './station';
import { MatDialog } from '@angular/material';
import { MapDialogComponent } from './map-dialog/map-dialog.component';
import { UpdateDialogComponent } from './update-dialog/update-dialog.component';
@Component({
  selector: 'app-station',
  templateUrl: './station.component.html',
  styleUrls: ['./station.component.scss']
})
export class StationComponent implements OnInit {
  @Input() station: Station;
  constructor(public dialog: MatDialog) {
  }

  ngOnInit() {
  }

  promptMap() {
    const dialogRef = this.dialog.open(MapDialogComponent, {
      width: '600px',
      data: {
        station: this.station
      }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('Map dialog was closed');
    });
  }

  promptUpdate() {
    const updateDiRef = this.dialog.open(UpdateDialogComponent, {
      width: '600px',
      data: {
        station: this.station
      }
    });

    updateDiRef.afterClosed().subscribe(result => {
      console.log('Update dialog was closed');
    });
  }

  promptDelete() {

  }

}
