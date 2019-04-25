import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { BodyComponent } from '../body.component';
import { ApiService } from 'src/app/api-service.service';
import { MatSnackBar, MatDialogRef } from '@angular/material';

@Component({
  selector: 'app-add-dialog',
  templateUrl: './add-dialog.component.html',
  styleUrls: ['./add-dialog.component.scss']
})
export class AddDialogComponent implements OnInit {
  enAddForm: FormGroup;
  tcAddForm: FormGroup;
  enAreas;
  tcAreas;
  enDistricts;
  tcDistricts;
  constructor(private fb: FormBuilder,
    private service: ApiService,
    private snackBar: MatSnackBar,
    public dialogRef: MatDialogRef<AddDialogComponent>) { }

  ngOnInit() {
    this.enAreas = BodyComponent.en_areas;
    this.tcAreas = BodyComponent.tc_areas;
    this.enDistricts = BodyComponent.en_districts;
    this.tcDistricts = BodyComponent.tc_districts;
    this.enAddForm = this.fb.group({
      lang: ['en', Validators.required],
      location: ['', Validators.required],
      lat: ['', Validators.required],
      lng: ['', Validators.required],
      type: ['', Validators.required],
      districtL: ['', Validators.required],
      districtS: ['', Validators.required],
      address: ['', Validators.required],
      provider: ['', Validators.required],
      parkingNo: ['', Validators.required],
      img: ['', Validators.required],
    });
    this.tcAddForm = this.fb.group({
      lang: ['tc', Validators.required],
      location: ['', Validators.required],
      lat: ['', Validators.required],
      lng: ['', Validators.required],
      type: ['', Validators.required],
      districtL: ['', Validators.required],
      districtS: ['', Validators.required],
      address: ['', Validators.required],
      provider: ['', Validators.required],
      parkingNo: ['', Validators.required],
      img: ['', Validators.required],
    });
  }

  addStation() {
    let data = {
      station : {
        en: this.enAddForm.value,
        tc: this.tcAddForm.value
      }
    }
    console.log(data);
    this.service.insert(data).subscribe(res=> {
      let a = JSON.stringify(res);
      let r = JSON.parse(a);
      if(r.result) {
        this.dialogRef.close(true);
      }
      this.snackBar.open(r.message, null, {
        duration: 2000
      });
    });
  }

}
