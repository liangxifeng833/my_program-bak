/*
 * 顺序查找算法  
 * 2015-08-18 
 */
#include<stdio.h>
/*
 * 最基础的顺序查找
 */
int sequence_search(int *a, int n, int key)
{
    int i; 
    for(i=1; i<=n; i++)
    {
        if(a[i] == key)
        {
            return i; 
        }
    }
    return 0; 
}
/*
 * 优化基础顺序查找
 */
int sequence_search2(int *a, int n, int key)
{
    int i; 
    //哨兵, 减少了在循环中做判断的操作, 在数据量特别大的情况下效率很高
    a[0] = key; 
    i = n; 
    while(a[i]!=key)
    {
        i--;
    }
    return i; 
}

main(void)
{
    int arr[10] = {1, 2, 3, 4, 5, 6, 7}; 
    printf("please input serach num:"); 
    int key; 
    scanf("%d", &key); 
    int res = sequence_search2(arr, 7, key); 
    if(res != 0)
    {
        printf("ok\n"); 
    }else
    {
        printf("no\n"); 
    }
}
