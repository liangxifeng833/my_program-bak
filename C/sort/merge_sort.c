/*
 * 归并排序算法
 * 2015-09-20 
 */
#include<stdio.h>
#include<malloc.h>

//将数组tmpR中的有序序列{i...m}和{m+1,n}  归并到新的有序序列newR中
mergeIng(int *tmpR, int *newR, int i, int m, int n)
{
    int j, k, l; 
    //将tmpR中记录由小到大归并入newR 中
    for(j=m+1, k=i; i<=m && j<=n; k++)
    {
        if(tmpR[i]<tmpR[j])
        {
            newR[k] = tmpR[i++]; 
        }else
        {
            newR[k] = tmpR[j++]; 
        }
    }
    if(i<=m)
    {
        for(l=0; l<=m-i; l++)
        {
            newR[k+l]=tmpR[i+l]; 
        }
    }
    if(j<=n)
    {
        for(l=0; l<=n-j; l++)
        {
            newR[k+l]=tmpR[j+l]; 
        }
    }
}


/*
* 归并排序递归实现, 先将无序序列拆分，然后在两两归并为有序序列
*/
void merge_sort(int *r,int *newR, int start, int len)
{
    int m; 
    int tmpR[15]; 
    //当递归调用到最后一个元素的时候，开始返回,调用mergeIng进行真正的二路归并排序
    if(start == len)
    {
        newR[start] = r[start]; 
    }else
    {
        m=(start+len)/2; 
        //递归地将r[start..m]归并为有序的tmpR[start..m]中
        merge_sort(r, tmpR, start, m); 
        //递归地将r[start+1..m]归并为有序的tmpR[start+..m]中
        merge_sort(r, tmpR, start+1 , len); 
        //将tmpR[start..m]和tmpR[m+1..len]归并到newR[start..len]中
        mergeIng(tmpR, newR, start, m, len); 
    }
}

//非递归方式
void MergeSort2(int *r, int len)
{
     int * TR=(int*)malloc(len*sizeof(int));  /* 申请额外空间 */
      int k=1; 
       while(k<len)
       {
            MergePass(r, TR, k, len); 
            k=2*k;         /* 子序列长度加倍 */
            MergePass(TR, r, k, len); 
            k=2*k;         /* 子序列长度加倍 */       
                    
       }

}
/* 将SR[]中相邻长度为s的子序列两两归并到TR[] */
void MergePass(int * SR, int * TR, int s, int n)
{
    int i=1; 
    int j; 
    while(i  <=  n-2*s+1) 
    { 
        mergeIng(SR, TR, i, i+s-1, i+2*s-1);  /* 两两归并 */
        i=i+2*s;         
    }
    if(i<n-s+1)  /* 归并最后两个序列 */
        mergeIng(SR, TR, i, i+s-1, n); 
    else   /* 若最后只剩下单个子序列 */
        for(j =i; j  <=  n; j++)
            TR[j] = SR[j]; 

}
    
main(void)
{
    //待排序序列
    int list[] = {0, 9, 1, 5, 8, 3, 7, 4, 6, 2, 10, 100, 98}; 
    //最后排好序的序列
    int newList[13]; 
    int len,  i; 
    //求数组长度
    len = sizeof(list)/sizeof(int); 
    len = len-1; //len-1 数组下标为0作为哨兵，不计入实际长度
    //merge_sort(list,newList,1, len); 
    MergeSort2(list, len)
    for(i=1; i<len+1; i++)
    {
        printf("%d\n", List[i]); 
    }
}
