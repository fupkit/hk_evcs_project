import { Component, OnInit, Input } from '@angular/core';
import { Station } from './station';
import { MatDialog } from '@angular/material';
import { MapDialogComponent } from './map-dialog/map-dialog.component';
import { UpdateDialogComponent } from './update-dialog/update-dialog.component';
import { Output, EventEmitter } from '@angular/core'; 
import { DeleteDialogComponent } from './delete-dialog/delete-dialog.component';
@Component({
  selector: 'app-station',
  templateUrl: './station.component.html',
  styleUrls: ['./station.component.scss']
})
export class StationComponent implements OnInit {
  @Input() station: Station;
  @Output() updateEvent = new EventEmitter<string>();
  constructor(public dialog: MatDialog) {
  }

  ngOnInit() {
  }

  promptMap() {
    const dialogRef = this.dialog.open(MapDialogComponent, {
      width: '600px',
      data: {
        stations: [this.station]
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
      if(result) {
        this.parentUpdate();
      }
    });
  }

  promptDelete() {
    const deleteDiRef = this.dialog.open(DeleteDialogComponent, {
      width: '600px',
      data: {
        station: this.station
      }
    });
    deleteDiRef.afterClosed().subscribe(result => {
      console.log('Delete dialog was closed');
      if(result === true) {
        this.parentUpdate();
      }
    });
  }

  parentUpdate() {
    this.updateEvent.next();
  }

}
