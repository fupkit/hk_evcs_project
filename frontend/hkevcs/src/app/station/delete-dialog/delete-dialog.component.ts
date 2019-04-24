import { Component, OnInit, Inject } from '@angular/core';
import { ApiService } from 'src/app/api-service.service';
import { MAT_DIALOG_DATA, MatSnackBar, MatDialogRef } from '@angular/material';

@Component({
  selector: 'app-delete-dialog',
  templateUrl: './delete-dialog.component.html',
  styleUrls: ['./delete-dialog.component.scss']
})
export class DeleteDialogComponent implements OnInit {
  id: number;
  constructor(
    private service: ApiService,
    @Inject(MAT_DIALOG_DATA) public data,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<DeleteDialogComponent>
  ) { }

  ngOnInit() {
    this.id = this.data.station.id;
  }

  deleteStation() {
    this.service.delete(this.id).subscribe(res=>{
      let a = JSON.stringify(res);
      let r = JSON.parse(a);
      console.log(r);
      this.snackBar.open(r.message);
      this.dialogRef.close(r.result);
    })
  }

  onNoClick() {
    this.dialogRef.close(false);
  }

}
