/*
 * 有序查找(二分查找/拆半查找) 
 * 2015-08-19
 */
#include<stdio.h>
#include<string.h>
int binary_search(int *a, int n, int key)
{
    int low, high, mid;  
    //最低下标为记录首位
    low = 1; 
    //最高下标为记录末位
    high = n; 
    while(low<=high)
    {
        //拆半
        mid = (low<high) ? (low+high)/2 : low;
        printf("mid = %d\n", mid); 
        if(key>a[mid])
        {
            low = mid+1; 
        }else if(key<a[mid])
        {
            high = mid-1; 
        }else
        {
            return mid; 
        }
    }
    return 0; 
}

main(void)
{
    int arr[] = {0, 1, 16, 24, 25, 35, 47, 59, 62, 73, 88, 99}; 
    int len, key; 
    len = sizeof(arr)/sizeof(int); 
    printf("please input search int:\n"); 
    scanf("%d", &key); 
    int res = binary_search(arr, len, key); 
    if(res == 0)
    {
        printf("search failed!\n"); 
        return; 
    }
    printf("search seccess!\n"); 
}
